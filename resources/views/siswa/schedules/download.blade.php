<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    {{-- <title>Jadwal Pelajaran</title> --}}

    <style>
        /* ===== A4 PAGE SETTING ===== */
        @page {
            size: A4;
            margin: 18mm 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            background-color: #ffffff;
        }

        h1 {
            text-align: center;
            margin-bottom: 4px;
            font-size: 20px;
            color: #1e3a8a;
        }

        .header {
            text-align: center;
            margin-bottom: 22px;
            font-size: 12px;
            color: #334155;
        }

        /* ===== CARD GRID ===== */
        .card-container {
            width: 100%;
        }

        .day-card {
            display: inline-block;
            width: 32%;
            margin-right: 1%;
            margin-bottom: 18px;
            vertical-align: top;
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #0400ff;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .day-card:nth-child(3n) {
            margin-right: 0;
        }

        /* ===== CARD HEADER ===== */
        .day-title {
            background-color: #1e40af;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            padding: 8px;
            border-radius: 10px 10px 0 0;
            letter-spacing: 0.5px;
        }

        /* ===== CARD BODY ===== */
        .card-body {
            padding: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px 2px;
            font-size: 10px;
            vertical-align: top;
            border-bottom: 1px dashed #0055ff;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .time {
            width: 38%;
            font-weight: bold;
            color: #1e3a8a;
        }

        .subject {
            font-weight: bold;
            color: #0f172a;
        }

        .teacher {
            font-size: 9px;
            color: #475569;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #475569;
        }
    </style>
</head>
<body>

    <h1>Jadwal Pelajaran</h1>

    <div class="header">
        <strong>Nama Siswa:</strong> {{ $student->user->name }} <br>
        <strong>Tahun Ajaran:</strong> 2025 / 2026
    </div>

    @php
        $days = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
        ];
    @endphp

    <div class="card-container">
        @foreach($schedules->groupBy('day') as $day => $items)
            <div class="day-card">
                <div class="day-title">
                    {{ $days[$day] ?? ucfirst($day) }}
                </div>

                <div class="card-body">
                    <table>
                        @foreach($items as $schedule)
                            <tr>
                                <td class="time">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </td>
                                <td>
                                    <div class="subject">
                                        {{ $schedule->subject->name }}
                                    </div>
                                    <div class="teacher">
                                        {{ $schedule->teacher->user->name }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        Dicetak pada {{ now()->translatedFormat('d F Y') }}
    </div>

</body>
</html>
