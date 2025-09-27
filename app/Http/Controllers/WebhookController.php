<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceiptMail;

class WebhookController extends Controller
{
    public function handlePayment(Request $request)
    {
        $payload = $request->all();

        $externalId = $payload['externalId'] ?? null;
        $status     = $payload['status'] ?? null;
        $amount     = (int) ($payload['amount'] ?? 0);

        $transaction = PaymentTransaction::where('external_id', $externalId)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Update transaction record
        $transaction->update([
            'amount_deposited' => $amount,
            'payment_date'     => now(),
            'status'           => $status,
        ]);

        $enrollment = $transaction->enrollment;
        $program    = $enrollment->program;

        // Calculate total deposits
        $totalPaid = $enrollment->paymentTransactions()
            ->where('status', 'SUCCESSFUL')
            ->sum('amount_deposited');

        // Determine enrollment status
        if ($totalPaid >= $program->cost) {
            $enrollment->update([
                'has_completed_payment' => true,
                'status'                => 'paid',
            ]);
        } elseif ($totalPaid > 0) {
            $enrollment->update([
                'has_completed_payment' => false,
                'status'                => 'partial_payment',
            ]);
        } else {
            $enrollment->update([
                'has_completed_payment' => false,
                'status'                => 'pending_payment',
            ]);
        }

        // Send receipt email if payment succeeded
        if ($status === 'SUCCESSFUL') {
            $remaining = max($program->cost - $totalPaid, 0);

            $receiptData = [
                'student'     => $enrollment->user,
                'program'     => $program,
                'amount_paid' => $amount,
                'total_paid'  => $totalPaid,
                'remaining'   => $remaining,
            ];

            Mail::to($enrollment->user->email)->send(new PaymentReceiptMail($receiptData));
        }

        return response()->json([
            'success'      => true,
            'total_paid'   => $totalPaid,
            'program_cost' => $program->cost,
            'status'       => $enrollment->status,
        ]);
    }

    public function checkPaymentStatus($transactionId)
    {
        $transaction = PaymentTransaction::where('external_id', $transactionId)
            ->with('enrollment')
            ->first();

        if (!$transaction) {
            return response()->json([
                'status'  => 'NOT_FOUND',
                'message' => 'Transaction not found',
            ], 404);
        }

        $enrollment = $transaction->enrollment;
        $program    = $enrollment->program;
        $totalPaid  = $enrollment->paymentTransactions()
            ->where('status', 'SUCCESSFUL')
            ->sum('amount_deposited');

        return response()->json([
            'status'       => $enrollment->status,
            'total_paid'   => $totalPaid,
            'program_cost' => $program->cost,
            'message'      => $enrollment->status === 'paid'
                ? 'Payment complete'
                : ($enrollment->status === 'partial_payment'
                    ? 'Partial payment received'
                    : 'Awaiting payment'),
        ]);
    }
}
