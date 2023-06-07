<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Student;
use App\Models\InvoiceSheet;

class StudentInvoice extends Model
{
    use HasFactory;

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function invoice_sheet(): BelongsTo
    {
        return $this->belongsTo(InvoiceSheet::class,'invoice_sheet_id','id');
    }
}
