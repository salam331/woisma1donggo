<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('student');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        $invoices = $query->paginate(10);
        $students = Student::all();

        return view('admin.invoices.index', compact('invoices', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('admin.invoices.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|unique:invoices',
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid,overdue',
            'payment_date' => 'nullable|date|required_if:status,paid',
        ]);

        Invoice::create($request->all());

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('student');
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $students = Student::all();
        return view('admin.invoices.edit', compact('invoice', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id,
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid,overdue',
            'paid_at' => 'nullable|date|required_if:status,paid',
        ]);

        $invoice->update($request->all());

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Process payment for the specified invoice.
     */
    public function payment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'pay_amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $payAmount = (float) $request->pay_amount;
        $totalAmount = (float) $invoice->amount;
        $currentPaidAmount = (float) ($invoice->paid_amount ?? 0);
        $newPaidAmount = $currentPaidAmount + $payAmount;

        // Check if payment amount is valid
        if ($newPaidAmount > $totalAmount) {
            return redirect()->back()
                ->with('error', 'Jumlah pembayaran melebihi total tagihan.')
                ->withInput();
        }

        // Build notes with payment history
        $paymentNote = '[' . date('d/m/Y H:i') . '] Pembayaran: Rp ' . number_format($payAmount, 0, ',', '.');
        if ($request->notes) {
            $paymentNote .= ' - Catatan: ' . $request->notes;
        }
        $newNotes = $invoice->notes ? $invoice->notes . '\n' . $paymentNote : $paymentNote;

        // Determine status based on payment
        $status = ($newPaidAmount >= $totalAmount) ? 'paid' : 'unpaid';

        // Update invoice
        $invoice->update([
            'status' => $status,
            'paid_amount' => $newPaidAmount,
            'payment_date' => $request->payment_date,
            'notes' => $newNotes,
        ]);

        $statusMessage = ($status === 'paid') ? 'Lunas' : 'Cicilan (' . number_format($newPaidAmount, 0, ',', '.') . '/' . number_format($totalAmount, 0, ',', '.') . ')';

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Pembayaran tagihan #' . $invoice->invoice_number . ' berhasil diproses. Status: ' . $statusMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}

