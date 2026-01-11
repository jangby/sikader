<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $registration->user->name }}</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { margin: 0; padding: 0; font-family: 'Times New Roman', serif; -webkit-print-color-adjust: exact; }
        
        .sheet {
            width: 297mm;
            height: 209mm; /* A4 Landscape Height */
            position: relative;
            background: white;
            overflow: hidden;
        }

        /* Border Hiasan (Double Border + Corner) */
        .border-outer {
            position: absolute;
            top: 10mm; left: 10mm; right: 10mm; bottom: 10mm;
            border: 2px solid #0f4c3a; /* Hijau NU Tua */
            padding: 5px;
        }
        .border-inner {
            border: 5px double #15803d; /* Hijau lebih muda */
            height: 100%;
            box-sizing: border-box;
            position: relative;
            background-image: radial-gradient(circle, #f0fff4 0%, #ffffff 70%); /* Background halus */
        }
        
        /* Ornamen Sudut (Opsional, pakai CSS Shape) */
        .corner {
            position: absolute; width: 40px; height: 40px;
            border-style: solid; border-color: #0f4c3a;
        }
        .tl { top: 0; left: 0; border-width: 10px 0 0 10px; }
        .tr { top: 0; right: 0; border-width: 10px 10px 0 0; }
        .bl { bottom: 0; left: 0; border-width: 0 0 10px 10px; }
        .br { bottom: 0; right: 0; border-width: 0 10px 10px 0; }

        /* Konten */
        .content {
            text-align: center;
            padding-top: 40px;
            color: #111;
        }

        .logo { width: 80px; margin-bottom: 10px; }
        .org-name { font-size: 18pt; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #0f4c3a; }
        .cert-title { 
            font-size: 36pt; 
            font-weight: bold; 
            margin: 10px 0 20px 0; 
            font-family: 'Georgia', serif; 
            text-transform: uppercase;
            letter-spacing: 5px;
            color: #b9860b; /* Warna Emas */
            text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
            border-bottom: 2px solid #b9860b;
            display: inline-block;
            padding-bottom: 5px;
        }
        
        .number { font-size: 10pt; margin-bottom: 30px; }

        .given-text { font-size: 14pt; margin-bottom: 10px; font-style: italic; }
        
        .name { 
            font-size: 28pt; 
            font-weight: bold; 
            text-transform: uppercase; 
            border-bottom: 1px dashed #333; 
            display: inline-block; 
            min-width: 400px;
            margin-bottom: 10px;
            color: #000;
        }

        .desc { font-size: 14pt; margin: 20px 0; line-height: 1.5; max-width: 80%; margin-left: auto; margin-right: auto; }
        
        /* Tanda Tangan */
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
            padding: 0 100px;
        }
        .sign-box { text-align: center; width: 200px; }
        .sign-role { font-weight: bold; font-size: 12pt; margin-bottom: 60px; }
        .sign-name { font-weight: bold; text-decoration: underline; font-size: 12pt; }
        .sign-id { font-size: 10pt; }

    </style>
</head>
<body onload="window.print()">

    <div class="sheet">
        <div class="border-outer">
            <div class="border-inner">
                <div class="corner tl"></div><div class="corner tr"></div>
                <div class="corner bl"></div><div class="corner br"></div>

                <div class="content">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/ec/Logo_IPNU.svg" class="logo" alt="Logo IPNU">
                    
                    <div class="org-name">PIMPINAN CABANG IKATAN PELAJAR NAHDLATUL ULAMA</div>
                    <div class="org-name" style="font-size: 12pt;">KABUPATEN {{ strtoupper(explode(' ', $event->lokasi)[0] ?? '..............') }}</div>

                    <div class="cert-title">SERTIFIKAT</div>
                    <div class="number">Nomor: {{ $certNo }}</div>

                    <p class="given-text">Diberikan kepada:</p>
                    <div class="name">{{ $registration->user->profile->nama_lengkap ?? $registration->user->name }}</div>
                    
                    <p class="desc">
                        Atas kelulusannya sebagai <b>PESERTA</b> pada acara <br>
                        <b>"{{ $event->nama_acara }}"</b><br>
                        Yang diselenggarakan pada tanggal {{ $event->tanggal_mulai->format('d F Y') }} di {{ $event->lokasi }}.
                    </p>

                    <div class="signatures">
                        <div class="sign-box">
                            <div class="sign-role">Sekretaris</div>
                            <div class="sign-name">.........................</div>
                            <div class="sign-id">NIA. ....................</div>
                        </div>
                        
                        <div class="sign-box">
                            <div class="sign-role">Ketua Pelaksana</div>
                            <div class="sign-name">.........................</div>
                            <div class="sign-id">NIA. ....................</div>
                        </div>

                         <div class="sign-box">
                            <div class="sign-role">Ketua PC IPNU</div>
                            <div class="sign-name">.........................</div>
                            <div class="sign-id">NIA. ....................</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>