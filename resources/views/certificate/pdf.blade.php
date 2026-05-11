<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat {{ $category }} - {{ $user->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .certificate-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: white;
            border: 20px solid #4f46e5; /* Border Biru Indigo */
            box-sizing: border-box;
        }
        /* Dekorasi Sudut */
        .decoration-top-right {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: #facc15;
            border-radius: 50%;
        }
        .content {
            padding: 60px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: 900;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 40px;
        }
        h1 {
            font-size: 60px;
            margin: 10px 0;
            color: #1e1b4b;
            text-transform: uppercase;
            letter-spacing: 5px;
        }
        .subtitle {
            font-size: 18px;
            color: #4f46e5;
            letter-spacing: 3px;
            margin-bottom: 30px;
        }
        .award-to {
            font-size: 20px;
            color: #64748b;
            margin-bottom: 10px;
        }
        .user-name {
            font-size: 45px;
            font-weight: bold;
            color: #1e1b4b;
            border-bottom: 2px dashed #facc15;
            display: inline-block;
            padding: 0 50px;
            margin-bottom: 20px;
        }
        .description {
            font-size: 16px;
            color: #475569;
            line-height: 1.6;
            max-width: 700px;
            margin: 0 auto 30px auto;
        }
        /* Tabel Skor Dinamis */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #ffffff;
        }
        th {
            background-color: #1e1b4b;
            color: white;
            padding: 12px;
            text-transform: uppercase;
            font-size: 12px;
        }
        td {
            padding: 20px;
            border: 1px solid #e2e8f0;
            font-size: 18px;
        }
        .score-val {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 100px;
        }
        .qr-code {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            display: inline-block;
            text-align: center;
            font-size: 10px;
            padding-top: 30px;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            border-top: 2px solid #1e1b4b;
            width: 200px;
            margin-top: 10px;
        }
        .badge {
            background: #facc15;
            color: #1e1b4b;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="certificate-container">
    <div class="decoration-top-right"></div>
    
    <div class="content">
        <div class="logo">KODESKUL.</div>
        
        <h1>CERTIFICATE</h1>
        <div class="subtitle">OF COMPLETION</div>
        
        <p class="award-to">This Certified Slay Award goes to:</p>
        <div class="user-name">{{ $user->name }}</div>
        
        <p class="description">
            Telah menyelesaikan pelatihan dan ujian akhir di kategori <strong>{{ strtoupper($category) }}</strong>
            dengan hasil yang memuaskan pada platform KodeSkul Academy.
        </p>

        <table>
            <thead>
                <tr>
                    <th>Bidang Keahlian</th>
                    <th>Skor Ujian</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">{{ strtoupper($category) }} DEVELOPER</td>
                    <td class="score-val">{{ $score }}</td>
                    <td style="font-weight: bold;">
                        @if($score >= 90) EXPERT 
                        @elseif($score >= 80) ADVANCED 
                        @else PRO 
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <span class="badge">{{ strtoupper($category) }} DEVELOPER</span>
        </div>

        <table style="border: none; width: 100%; margin-top: 40px;">
            <tr>
                <td style="border: none; text-align: left; width: 33%;">
                    <div class="qr-code">
                        VALIDATED BY<br>QR CODE
                    </div>
                </td>
                <td style="border: none; text-align: center; width: 33%;">
                    <p style="font-size: 12px; color: #64748b;">Issued on: {{ $date }}</p>
                </td>
                <td style="border: none; text-align: right; width: 33%;">
                    <div class="signature">
                        <p style="font-weight: bold; margin-bottom: 5px;">KodeSkul Academy</p>
                        <div class="signature-line"></div>
                        <p style="font-size: 10px;">Verification ID: KS-{{ rand(1000,9999) }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>