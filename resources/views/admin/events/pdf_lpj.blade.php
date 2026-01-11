<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LPJ Keuangan - {{ $event->nama_acara }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 0; padding: 0; }
        .container { width: 210mm; margin: 0 auto; padding: 10mm; }
        
        /* Kop Surat */
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 12pt; margin: 5px 0; }
        
        /* Judul */
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; text-transform: uppercase; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11pt; }
        th, td { border: 1px solid #000; padding: 5px 8px; }
        th { background-color: #eee; text-align: center; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .no-border { border: none !important; }

        /* Tanda Tangan */
        .signature { display: flex; justify-content: space-between; margin-top: 40px; page-break-inside: avoid; }
        .sign-box { text-align: center; width: 40%; }
        .sign-name { margin-top: 70px; font-weight: bold; text-decoration: underline; }

        @media print {
            body { margin: 0; }
            .container { width: 100%; margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        
        <div class="header">
            <h1>LAPORAN PERTANGGUNGJAWABAN KEUANGAN</h1>
            <h2>KEGIATAN {{ strtoupper($event->nama_acara) }}</h2>
            <p style="font-size: 10pt; margin: 0;">{{ $event->lokasi }} | {{ $event->tanggal_mulai->format('d F Y') }}</p>
        </div>

        <div class="title">REKAPITULASI DANA</div>

        <h3 style="font-size: 11pt; margin-bottom: 5px;">A. PEMASUKAN</h3>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Uraian / Sumber Dana</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Nominal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Kontribusi Peserta ({{ $jumlahPesertaBayar }} org x Rp {{ number_format($event->biaya,0,',','.') }})</td>
                    <td class="text-center">-</td>
                    <td class="text-right">Rp {{ number_format($totalPemasukanPeserta, 0, ',', '.') }}</td>
                </tr>
                @foreach($pemasukan as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 2 }}</td>
                    <td>{{ $row->keterangan }}</td>
                    <td class="text-center">{{ $row->tanggal->format('d/m/Y') }}</td>
                    <td class="text-right">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right font-bold">TOTAL PEMASUKAN (A)</td>
                    <td class="text-right font-bold">Rp {{ number_format($grandTotalPemasukan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h3 style="font-size: 11pt; margin-bottom: 5px;">B. PENGELUARAN</h3>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Uraian Pengeluaran</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluaran as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row->keterangan }}</td>
                    <td class="text-center">{{ $row->tanggal->format('d/m/Y') }}</td>
                    <td class="text-right">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                @if($pengeluaran->isEmpty())
                <tr><td colspan="4" class="text-center">- Nihil -</td></tr>
                @endif
                <tr>
                    <td colspan="3" class="text-right font-bold">TOTAL PENGELUARAN (B)</td>
                    <td class="text-right font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h3 style="font-size: 11pt; margin-bottom: 5px;">C. SALDO AKHIR</h3>
        <table style="width: 50%; margin-left: auto;">
            <tr>
                <td class="no-border">Total Pemasukan (A)</td>
                <td class="text-right no-border">Rp {{ number_format($grandTotalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="border-bottom: 1px solid black !important;">Total Pengeluaran (B)</td>
                <td class="text-right no-border" style="border-bottom: 1px solid black !important;">(Rp {{ number_format($totalPengeluaran, 0, ',', '.') }})</td>
            </tr>
            <tr>
                <td class="font-bold no-border">SISA SALDO KAS</td>
                <td class="text-right font-bold no-border">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="signature">
            <div class="sign-box">
                <p>Bendahara Pelaksana</p>
                <div class="sign-name">....................................</div>
            </div>
            <div class="sign-box">
                <p>{{ explode(',', $event->lokasi)[0] ?? 'Tempat' }}, {{ date('d F Y') }}</p>
                <p>Ketua Pelaksana</p>
                <div class="sign-name">....................................</div>
            </div>
        </div>

    </div>
</body>
</html>