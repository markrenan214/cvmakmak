<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.html");
    exit();
}

// Data Processing
$fullname  = htmlspecialchars($_POST['fullname'] ?? 'Unnamed Explorer');
$email     = htmlspecialchars($_POST['email'] ?? '');
$phone     = htmlspecialchars($_POST['phone'] ?? '');
$address   = htmlspecialchars($_POST['address'] ?? '');
$summary   = htmlspecialchars($_POST['summary'] ?? '');
$education = htmlspecialchars($_POST['education'] ?? '');
$skills    = htmlspecialchars($_POST['skills'] ?? '');

// Image Handling
$photoData = "";
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
    $imgBinary = file_get_contents($_FILES['profile_pic']['tmp_name']);
    $photoData = "data:" . $_FILES['profile_pic']['type'] . ";base64," . base64_encode($imgBinary);
} else {
    $photoData = "https://ui-avatars.com/api/?name=" . urlencode($fullname) . "&size=300&background=556b2f&color=fff";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedition Report - <?php echo $fullname; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Special+Elite&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2d3436;
            --accent: #8b4513;
            --sidebar: #f4f1ea;
            --white: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #dcdde1;
            padding: 50px 20px;
            color: var(--primary);
        }

        .cv-wrapper {
            width: 210mm;
            min-height: 297mm;
            background: var(--white);
            margin: 0 auto;
            display: flex;
            box-shadow: 0 0 50px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        /* Side Aesthetic Stripe */
        .cv-wrapper::before {
            content: ''; position: absolute; left: 0; top: 0; width: 8px; height: 100%;
            background: var(--accent);
        }

        /* 1. Sidebar */
        .sidebar {
            width: 35%;
            background: var(--sidebar);
            padding: 50px 30px;
            border-right: 1px solid #e0dcd0;
        }

        .profile-img-container {
            width: 100%;
            aspect-ratio: 1;
            border: 8px solid var(--white);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .profile-img-container img { width: 100%; height: 100%; object-fit: cover; }

        .sidebar-section { margin-bottom: 35px; }

        .sidebar-title {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent);
            margin-bottom: 15px;
            border-bottom: 1px solid #dcdde1;
            padding-bottom: 5px;
        }

        .contact-info { font-size: 12px; line-height: 2; word-break: break-all; }
        .contact-info i { color: var(--accent); width: 25px; }

        /* 2. Main Content */
        .main-content {
            width: 65%;
            padding: 60px 50px;
        }

        .header-title h1 {
            font-size: 42px;
            font-weight: 900;
            line-height: 1;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .header-title p {
            font-family: 'Special Elite', cursive;
            font-size: 16px;
            color: var(--accent);
            margin-bottom: 50px;
        }

        .content-section { margin-bottom: 45px; }

        .section-header {
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-header::after {
            content: ''; height: 2px; flex-grow: 1; background: #eee; margin-left: 20px;
        }

        .text-body {
            font-size: 14px;
            line-height: 1.8;
            color: #57606f;
            white-space: pre-line;
        }

        /* Skill Chips - Rugged Style */
        .skill-tag {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 6px 15px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 8px 8px 0;
            border-radius: 2px;
        }

        /* Footer Stamp */
        .stamp {
            position: absolute;
            bottom: 50px; right: 50px;
            border: 3px solid rgba(139, 69, 19, 0.3);
            color: rgba(139, 69, 19, 0.3);
            padding: 10px;
            font-family: 'Special Elite', cursive;
            transform: rotate(-15deg);
            text-transform: uppercase;
            pointer-events: none;
        }

        .action-btns { margin-top: 30px; display: flex; gap: 15px; }
        .btn {
            padding: 12px 25px; font-family: 'Montserrat', sans-serif;
            font-weight: 700; text-decoration: none; cursor: pointer; border-radius: 4px;
        }
        .btn-print { background: var(--accent); color: white; border: none; }
        .btn-back { background: white; color: var(--accent); border: 1px solid var(--accent); }

        @media print {
            body { padding: 0; background: white; }
            .cv-wrapper { box-shadow: none; margin: 0; width: 100%; }
            .action-btns { display: none; }
        }
    </style>
</head>
<body>

    <div class="cv-wrapper">
        <aside class="sidebar">
            <div class="profile-img-container">
                <img src="<?php echo $photoData; ?>" alt="Explorer">
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">CONTACT INFO</h3>
                <div class="contact-info">
                    <p><i class="fa-solid fa-paper-plane"></i> <?php echo $email; ?></p>
                    <p><i class="fa-solid fa-satellite"></i> <?php echo $phone; ?></p>
                    <p><i class="fa-solid fa-map-location-dot"></i> <?php echo $address; ?></p>
                </div>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">SKILLS</h3>
                <div>
                    <?php 
                    $skillsList = explode(',', $skills);
                    foreach($skillsList as $s) {
                        if(trim($s) != "") echo '<span class="skill-tag">' . trim($s) . '</span>';
                    }
                    ?>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="header-title">
                <h1><?php echo $fullname; ?></h1>
                <p>STATUS: IT SPECIALIST / WEB DEVELOPER</p>
            </div>

            <section class="content-section">
                <h2 class="section-header">SUMMARY/BIO</h2>
                <div class="text-body"><?php echo $summary; ?></div>
            </section>

            <section class="content-section">
                <h2 class="section-header">EDUCATION</h2>
                <div class="text-body"><?php echo $education; ?></div>
            </section>

            <div class="stamp">Verified Report<br><?php echo date('Y-m-d'); ?></div>
        </main>
    </div>

    <div class="action-btns">
        <button class="btn btn-print" onclick="window.print()">Print CV</button>
        <a href="index.html" class="btn btn-back">BAck</a>
    </div>

</body>
</html>
