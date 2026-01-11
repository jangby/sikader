<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - {{ $schedule->nama_sesi }}</title>
    <style>
        /* Reset & Base Style */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            background: #ccc; /* Background abu-abu di browser biar kertas terlihat */
        }

        /* Simulasi Kertas A4 */
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Saat Print / Save as PDF */
        @media print {
            body { background: white; margin: 0; }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                padding: 0; /* Margin diatur oleh browser */
            }
            @page {
                size: A4;
                margin: 2cm;
            }
        }

        /* Komponen Kop Surat */
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .header p { font-size: 10pt; margin: 0; font-style: italic; }

        /* Judul Dokumen */
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            text-transform: uppercase;
        }

        /* Info Sesi */
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        .label { width: 150px; font-weight: bold; }

        /* Tabel Data */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid black;
            padding: 6px 8px;
            font-size: 11pt;
        }
        .data-table th { background-color: #f0f0f0; text-align: center; }
        .center { text-align: center; }

        /* Tanda Tangan */
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .sign-box { text-align: center; width: 40%; }
        .sign-name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="page">
        <div class="header">
            <h1>PIMPINAN CABANG</h1>
            <h1>IKATAN PELAJAR NAHDLATUL ULAMA</h1>
            <h2>KABUPATEN {{ strtoupper(explode(' ', $event->lokasi)[0] ?? '..............') }}</h2>
            <p>{{ $event->nama_acara }} | {{ $event->lokasi }}</p>
        </div>

        <div class="title">DAFTAR HADIR PESERTA</div>

        <table class="info-table">
            <tr>
                <td class="label">Nama Sesi / Materi</td>
                <td>: {{ $schedule->nama_sesi }}</td>
            </tr>
            <tr>
                <td class="label">Hari, Tanggal</td>
                <td>: {{ $schedule->waktu_mulai->format('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>: {{ $schedule->waktu_mulai->format('H:i') }} - {{ $schedule->waktu_selesai->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Jumlah Hadir</td>
                <td>: {{ $attendees->count() }} Orang (L: {{ $hadirLk->count() }}, P: {{ $hadirPr->count() }})</td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Lengkap</th>
                    <th style="width: 10%">L/P</th>
                    <th style="width: 30%">Asal Delegasi</th>
                    <th style="width: 15%">Paraf</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $index => $attendance)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ strtoupper($attendance->registration->user->profile->nama_lengkap ?? 'User') }}</td>
                    <td class="center">
                        @if(optional($attendance->registration->user->profile)->jenis_kelamin == 'Laki-laki') L
                        @elseif(optional($attendance->registration->user->profile)->jenis_kelamin == 'Perempuan') P
                        @else - @endif
                    </td>
                    <td>{{ $attendance->registration->user->profile->asal_delegasi ?? '-' }}</td>
                    <td class="center">
                        <span style="font-size: 8pt; color: #555;">{{ $attendance->scanned_at->format('H:i') }}</span>
                    </td>
                </tr>
                @endforeach

                @if($attendees->isEmpty())
                <tr>
                    <td colspan="5" class="center" style="padding: 20px;">-- Tidak ada data kehadiran --</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="signature">
            <div class="sign-box">
                <p>Mengetahui,<br>Sekretaris Pelaksana</p>
                <div class="sign-name">....................................</div>
                <p>NI. .........................</p>
            </div>
            <div class="sign-box">
                <p>{{ explode(',', $event->lokasi)[0] ?? 'Tempat' }}, {{ date('d F Y') }}<br>Ketua Pelaksana</p>
                <div class="sign-name">....................................</div>
                <p>NI. .........................</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>