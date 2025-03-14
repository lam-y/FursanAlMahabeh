<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class MembersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $members = Member::with([
                                'memberType',
                                'branch',
                                'branchBadge',
                                'hobbyBadges',
                                'publicBadges',
                                'branchBadges'
                            ])
                            ->get();

        return $members->map(function ($member) {
            return [
                'الاسم' => $member->name,
                'اسم الأب' => $member->father_name ?? '',
                'اسم الأم' => $member->mother_name ?? '',
                'تاريخ الميلاد' => $member->birth_date ?? '',
                'رقم الفارس' => $member->member_phone ?? '',
                'رقم الأب' => $member->father_phone ?? '',
                'رقم الأم' => $member->mother_phone ?? '',
                'العنوان' => $member->address ?? '',
                'المدرسة' => $member->school ?? '',
                'الصف' => optional($member->grade)->name,
                'تاريخ الانضمام' => $member->register_date ?? '',
                'مثبت (فولار)' => $member->foulard_text,
                'درجة مبتدئ' => $member->junior_degree_text,
                'درجة ثانية' => $member->second_degree_text,
                'أوسمة (هوايات)' => optional($member->hobbyBadges)->pluck('name')->implode(', '),
                'أوسمة فرع' => optional($member->branchBadges)->pluck('name')->implode(', '),
                'نوع العضوية' => optional($member->memberType)->name ,
                'ترفيع' => $member->promoted_text,
                'الفرع' => optional($member->branch)->name,
                'توتيم' => $member->totem_text,
                'التوتيم' => $member->totem_name ?? '',
                'أوسمة عامة' => optional($member->publicBadges)->pluck('name')->implode(', '),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'اسم الأب',
            'اسم الأم',
            'تاريخ الميلاد',
            'رقم الفارس',
            'رقم الأب',
            'رقم الأم',
            'العنوان',
            'المدرسة',
            'الصف',
            'تاريخ الانضمام',
            'مثبت (فولار)',
            'درجة مبتدئ',
            'درجة ثانية',
            'أوسمة (هوايات)',
            'أوسمة فرع',
            'نوع العضوية',
            'ترفيع',
            'الفرع',
            'توتيم',
            'التوتيم',
            'أوسمة عامة',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $styleArray = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD3D3D3'],
                    ],
                ];

                // تطبيق الأنماط على الخلايا
                $event->sheet->getDelegate()->getStyle('A1:W1')->applyFromArray($styleArray);
            },
        ];
    }

}
