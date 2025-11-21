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
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
