<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Completion Certificate</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #333;
        }
        .certificate {
            width: 1100px;
            height: 750px;
            padding: 20px;
            text-align: center;
            border: 20px solid #0066cc;
            position: relative;
        }
        .certificate:after {
            content: '';
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            z-index: -1;
            background-image: url('/public/images/certificate-bg.png');
            background-size: cover;
            opacity: 0.1;
        }
        .border {
            width: 1060px;
            height: 710px;
            padding: 20px;
            text-align: center;
            border: 5px solid #0066cc;
            margin: 0;
        }
        .content {
            padding: 20px;
            margin: 0 auto;
        }
        .logo {
            width: 300px;
            margin: 0 auto 20px;
        }
        h1 {
            font-size: 50px;
            font-weight: bold;
            color: #0066cc;
            margin: 20px 0;
        }
        h2 {
            font-size: 30px;
            margin: 20px 0;
        }
        p {
            font-size: 20px;
            margin: 10px 0;
        }
        .recipient {
            font-size: 40px;
            margin: 20px 0;
            color: #0066cc;
            font-family: 'Dancing Script', cursive;
        }
        .date {
            font-size: 20px;
            margin: 20px 0;
        }
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
        }
        .signature {
            border-top: 2px solid #333;
            width: 250px;
            padding-top: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="border">
            <div class="content">
                <div class="logo">
                    <img src="/public/images/logo.png" alt="Corporate Tools Logo" width="300">
                </div>
                <h1>Certificate of Completion</h1>
                <h2>This is to certify that</h2>
                <p class="recipient"><?= $this->sanitize($user['name']) ?></p>
                <p>has successfully completed the course</p>
                <h2><?= $this->sanitize($lesson['title']) ?></h2>
                <p class="date">Completed on <?= date('F j, Y', strtotime($completion_date)) ?></p>
                
                <div class="signatures">
                    <div class="signature">
                        <?= $this->sanitize($instructor['name']) ?><br>
                        Course Instructor
                    </div>
                    <div class="signature">
                        <?= $this->sanitize($admin['name']) ?><br>
                        Training Administrator
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
