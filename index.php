<?php
// index.php - Premium Cinematic Navy Frontend Portfolio
require_once __DIR__ . '/config.php';

$db_data = get_db_data();

$biodata = isset($db_data['biodata']) ? $db_data['biodata'] : [];
$experiences = isset($db_data['experiences']) ? $db_data['experiences'] : [];
$certificates = isset($db_data['certificates']) ? $db_data['certificates'] : [];
$socmed = isset($db_data['socmed']) ? $db_data['socmed'] : [];
$portfolio = isset($db_data['portfolio']) ? $db_data['portfolio'] : [];

$name = isset($biodata['name']) ? $biodata['name'] : '';
$role = isset($biodata['role']) ? $biodata['role'] : '';
$description = isset($biodata['description']) ? $biodata['description'] : '';
$photo = isset($biodata['photo']) ? $biodata['photo'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($name) ? htmlspecialchars($name) . ' - Professional Portfolio' : 'Creative Portfolio' ?></title>
    
    <meta name="description" content="Personal Portfolio Website. Explore professional projects, development, design, and work experiences.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        /* =============================================
           CLEAN BLACK AND WHITE THEME
           ============================================= */
        :root {
            --bg-deep:        #FFFFFF;   /* Pure White Background */
            --bg-card:        #F9FAFB;   /* Off White Card */
            --card-bg:        #FFFFFF;   /* Main Card Bg */
            --border-steel:   #E5E7EB;   /* Light Gray Border */
            --text-muted:     #6B7280;   /* Muted Gray Text */
            --text-main:      #111827;   /* Near Black Text */

            /* Legacy aliases kept for compat */
            --bg-deep-navy:   #FFFFFF;
            --bg-card-glass:  rgba(255, 255, 255, 0.9);
            --accent-cyan:    #111827;
            --accent-blue:    #6B7280;
            --glass-border:   rgba(229, 231, 235, 0.8);
            --font-heading:   'Montserrat', sans-serif;
            --font-body:      'Inter', sans-serif;
            --neon-glow:      0 4px 12px rgba(0, 0, 0, 0.05);
            --steel-glow:     0 8px 24px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        html {
            overflow-x: hidden;
        }

        body {
            overflow-x: hidden;
            position: relative;
            font-family: var(--font-body);
            background-color: var(--bg-deep);
            background-image:
                radial-gradient(ellipse at 15% 10%, rgba(0,0,0,0.03) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 85%, rgba(0,0,0,0.02) 0%, transparent 50%);
            color: var(--text-main);
            line-height: 1.7;
        }

        .container {
            width: 90%;
            max-width: 1240px;
            margin: 0 auto;
        }

        /* Abstract ambient blobs */
        @keyframes pulseGlow {
            0%   { transform: scale(1) translate(0,0);       opacity: 0.5; }
            50%  { transform: scale(1.12) translate(30px,-20px); opacity: 0.75; }
            100% { transform: scale(1) translate(0,0);       opacity: 0.5; }
        }

        .glow-blob {
            position: absolute;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,0,0,0.03) 0%, rgba(255,255,255,0) 70%);
            pointer-events: none;
            z-index: -1;
            filter: blur(90px);
            animation: pulseGlow 14s ease-in-out infinite alternate;
        }

        /* ── FIXED CINEMATIC NAVBAR ── */
        header {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            z-index: 1000;
            padding: 28px 0;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 16px 0;
            border-bottom: 1px solid var(--border-steel);
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        }

        nav { display: flex; justify-content: space-between; align-items: center; }

        .logo {
            font-family: var(--font-heading);
            font-weight: 900;
            font-size: 1.3rem;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .logo i { color: var(--text-muted); font-size: 1.1rem; }

        .nav-links { display: flex; list-style: none; gap: 38px; align-items: center; }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: color 0.3s ease;
            position: relative;
            padding-bottom: 4px;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 1px;
            background: var(--text-main);
            transition: width 0.3s ease;
        }
        .nav-links a:hover { color: var(--text-main); }
        .nav-links a:hover::after { width: 100%; }

        /* ── SECTIONS GENERAL ── */
        section { padding: 140px 0; position: relative; }

        .section-header { text-align: center; margin-bottom: 80px; }

        .section-header h2 {
            font-family: var(--font-heading);
            font-size: 2.6rem;
            color: var(--text-main);
            font-weight: 900;
            letter-spacing: 3px;
            margin-bottom: 16px;
            text-transform: uppercase;
        }
        .section-header h2 span { color: var(--text-muted); }

        .section-header p {
            color: var(--text-muted);
            font-size: 0.98rem;
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* Steel divider under heading */
        .section-header::after {
            content: '';
            display: block;
            width: 50px; height: 2px;
            background: var(--border-steel);
            margin: 22px auto 0;
        }

        /* ── HERO SECTION — ASYMMETRIC FILM POSTER ── */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 120px;
            background:
                linear-gradient(160deg, rgba(0,0,0,0.03) 0%, transparent 60%);
        }

        .hero-layout {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 90px;
            align-items: center;
        }

        /* LEFT — Film Poster Frame */
        .hero-image-side {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .profile-card-wrapper {
            position: relative;
            width: 100%;
            max-width: 360px;
            aspect-ratio: 3 / 4;
            border-radius: 16px;
            border: 1px solid var(--border-steel);
            overflow: hidden;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.05), 0 40px 80px rgba(0,0,0,0.1);
            transition: box-shadow 0.5s ease, transform 0.5s ease;
        }
        .profile-card-wrapper:hover {
            transform: translateY(-8px);
            box-shadow: 0 0 0 1px var(--border-steel), 0 50px 100px rgba(0,0,0,0.15), var(--steel-glow);
        }

        .profile-inner-frame { width: 100%; height: 100%; position: relative; }

        .profile-inner-frame img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center top;
            display: block;
            transition: transform 0.7s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .profile-card-wrapper:hover .profile-inner-frame img { transform: scale(1.06); }

        /* Dark gradient overlay at bottom of portrait */
        .profile-inner-frame::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 45%;
            background: linear-gradient(to top, var(--bg-deep) 0%, transparent 100%);
            pointer-events: none;
        }

        /* Floating Cinematic Badges */
        .floating-pill {
            position: absolute;
            background: rgba(255,255,255,0.88);
            border: 1px solid var(--border-steel);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 10px 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-main);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            animation: floatingMotion 5s ease-in-out infinite alternate;
            z-index: 5;
            transition: all 0.3s ease;
        }
        .floating-pill:hover { border-color: var(--text-main); }

        @keyframes floatingMotion {
            0%   { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }

        .pill-1 { top: 20px; left: 20px; animation-delay: 0s; }
        .pill-2 { bottom: 30px; right: 20px; animation-delay: 1s; }
        .floating-pill i { color: var(--text-muted); font-size: 0.95rem; }

        /* RIGHT — Hero Text */
        .hero-text-side { display: flex; flex-direction: column; }

        .hero-badge {
            align-self: flex-start;
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-steel);
            padding: 6px 18px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .hero-text-side h1 {
            font-family: var(--font-heading);
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 20px;
            letter-spacing: -1.5px;
            color: var(--text-main);
        }
        .hero-text-side h1 span { color: var(--text-muted); }

        .hero-role-title {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .hero-role-title::before {
            content: '';
            display: inline-block;
            width: 30px; height: 2px;
            background: var(--border-steel);
        }

        .hero-desc {
            font-size: 1rem;
            color: var(--text-muted);
            line-height: 1.85;
            margin-bottom: 44px;
            max-width: 480px;
        }

        /* Social Row */
        .social-container {
            border-top: 1px solid var(--border-steel);
            padding-top: 32px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .social-headline {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            opacity: 0.7;
        }
        .social-flex-row { display: flex; gap: 10px; }

        .social-neon-btn {
            width: 44px; height: 44px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid var(--border-steel);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .social-neon-btn:hover {
            background: var(--border-steel);
            color: var(--text-main);
            transform: translateY(-4px);
            box-shadow: var(--steel-glow);
        }

        /* ══════════════════════════════════════════════
           FILMSTRIP TIMELINE — Production Ledger Style
           ══════════════════════════════════════════════ */
        #experiences { background: rgba(249,250,251,0.6); }

        .timeline-container {
            position: relative;
            max-width: 950px;
            margin: 0 auto;
        }

        /* Dashed center track like a film reel */
        .timeline-container::before {
            content: '';
            position: absolute;
            width: 1px;
            border-left: 2px dashed var(--border-steel);
            top: 10px; bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.5;
        }

        .timeline-node {
            position: relative;
            margin-bottom: 60px;
            width: 100%;
        }
        .timeline-node::after { content: ''; display: table; clear: both; }

        /* Film frame circle pointer */
        .timeline-pointer {
            width: 14px; height: 14px;
            border-radius: 50%;
            background: var(--bg-deep);
            border: 2px solid var(--text-main);
            position: absolute;
            left: 50%; top: 28px;
            transform: translateX(-50%);
            z-index: 5;
            box-shadow: 0 0 0 5px rgba(255,255,255,0.9), 0 0 18px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
        }
        .timeline-node:hover .timeline-pointer {
            background: var(--text-main);
            transform: translateX(-50%) scale(1.5);
            box-shadow: 0 0 0 6px rgba(255,255,255,0.95), 0 0 30px rgba(0,0,0,0.1);
        }

        /* Card — industrial dark architecture */
        .timeline-bubble {
            width: 43%;
            background: var(--card-bg);
            border: 1px solid var(--border-steel);
            border-radius: 12px;
            padding: 32px 36px;
            position: relative;
            box-shadow: 0 12px 32px rgba(0,0,0,0.05);
            transition: all 0.45s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
        }
        .timeline-bubble::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--border-steel), var(--text-muted));
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .timeline-node:hover .timeline-bubble {
            transform: translateY(-6px) scale(1.01);
            border-color: var(--text-muted);
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }
        .timeline-node:hover .timeline-bubble::before { opacity: 1; }

        .timeline-node:nth-child(even) .timeline-bubble { float: right; }
        .timeline-node:nth-child(odd)  .timeline-bubble { float: left; }

        /* Year badge — top-right corner */
        .timeline-meta-year {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-muted);
            background: rgba(0,0,0,0.05);
            border: 1px solid var(--border-steel);
            padding: 4px 12px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .timeline-role {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            color: var(--text-main);
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        .timeline-org {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }
        .timeline-org i { color: var(--border-steel); }

        .timeline-paragraph {
            color: var(--text-muted);
            font-size: 0.88rem;
            line-height: 1.7;
        }

        /* CERTIFICATES SECTION - GLASSMORPHIC SLIDER */
        .cert-slider-outer {
            position: relative;
            width: 100%;
        }

        .cert-swiper-container {
            overflow: hidden;
            width: 100%;
            padding: 20px 0 40px 0;
        }

        .cert-slider-track {
            display: flex;
            gap: 30px;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .cert-glass-card {
            flex: 0 0 calc((100% - 60px) / 3);
            background: var(--bg-card-glass);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 24px;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cert-glass-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 0, 0, 0.15);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        }

        .cert-asset-box {
            width: 100%;
            height: 190px;
            background: #F3F4F6;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .cert-asset-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .cert-glass-card:hover .cert-asset-box img {
            transform: scale(1.06);
        }

        .cert-asset-box iframe {
            width: 100%;
            height: 100%;
            border: none;
            pointer-events: none;
        }

        .cert-asset-box .asset-shield-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: transparent;
            z-index: 2;
        }

        .cert-asset-box .icon-fallback {
            font-size: 3rem;
            color: rgba(159,184,201,0.3);
        }

        .cert-details h3 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            color: var(--text-main);
            font-weight: 800;
            line-height: 1.4;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.8em;
            letter-spacing: 0.3px;
        }

        .cert-details p {
            color: var(--text-muted);
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
        }

        .cert-details p i { color: var(--border-steel); }

        .btn-action-trigger {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-steel);
            padding: 11px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            width: 100%;
        }

        .btn-action-trigger:hover {
            background: var(--border-steel);
            color: var(--text-main);
            box-shadow: var(--steel-glow);
        }

        /* Slider Controls */
        .slider-custom-controls {
            display: flex; align-items: center; justify-content: center;
            gap: 22px; margin-top: 28px;
        }
        .control-arrow-btn {
            width: 42px; height: 42px; border-radius: 8px;
            background: transparent; border: 1px solid var(--border-steel);
            color: var(--text-muted); font-size: 0.85rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s ease;
        }
        .control-arrow-btn:hover {
            background: var(--border-steel); color: var(--text-main);
        }
        .slider-pills-indicator { display: flex; gap: 6px; align-items: center; }
        .slider-pill-dot {
            width: 14px; height: 3px; border-radius: 4px;
            background: rgba(159,184,201,0.2); cursor: pointer; transition: all 0.3s ease;
        }
        .slider-pill-dot.active {
            width: 28px; background: var(--text-muted);
        }

        /* ── PORTFOLIO SHOWCASE — 16:9 CINEMATIC CARDS ── */
        .portfolio-matrix {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(370px, 1fr));
            gap: 28px;
        }

        .portfolio-neon-card {
            background: var(--card-bg);
            border: 1px solid var(--border-steel);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.45s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .portfolio-neon-card:hover {
            transform: translateY(-10px);
            border-color: var(--text-muted);
            box-shadow: 0 30px 60px rgba(0,0,0,0.1), var(--steel-glow);
        }

        /* 16:9 widescreen viewport */
        .portfolio-carousel-viewport {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #F3F4F6;
            position: relative;
            overflow: hidden;
        }
        .project-swiper { width: 100%; height: 100%; }
        .project-swiper .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
        .project-swiper .swiper-slide iframe { width: 100%; height: 100%; border: none; }

        .project-swiper .swiper-button-next,
        .project-swiper .swiper-button-prev {
            color: var(--bg-deep);
            background: rgba(255,255,255,0.9);
            border: 1px solid var(--border-steel);
            width: 34px; height: 34px; border-radius: 6px;
            opacity: 0; transition: all 0.3s ease;
        }
        .project-swiper:hover .swiper-button-next,
        .project-swiper:hover .swiper-button-prev { opacity: 1; }
        .project-swiper .swiper-button-next::after,
        .project-swiper .swiper-button-prev::after { font-size: 11px; font-weight: bold; }
        .project-swiper .swiper-pagination-bullet { background: var(--text-muted); opacity: 0.5; }
        .project-swiper .swiper-pagination-bullet-active { background: var(--text-main) !important; opacity: 1; }

        .portfolio-main-body { padding: 26px 28px; flex-grow: 1; }
        .portfolio-main-body h3 {
            font-family: var(--font-heading);
            font-size: 1.2rem; color: var(--text-main);
            font-weight: 800; margin-bottom: 10px; letter-spacing: 0.3px;
        }
        .portfolio-main-body p {
            color: var(--text-muted); font-size: 0.88rem; line-height: 1.65;
            display: -webkit-box; -webkit-line-clamp: 3;
            -webkit-box-orient: vertical; overflow: hidden;
        }

        .portfolio-interactive-footer { padding: 0 28px 28px; display: flex; gap: 10px; }

        .btn-internal-action {
            flex: 1; padding: 11px 14px; border-radius: 8px;
            font-size: 0.78rem; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; text-align: center; text-decoration: none;
            transition: all 0.3s ease; display: flex;
            align-items: center; justify-content: center; gap: 8px; cursor: pointer;
        }
        .btn-internal-primary {
            background: var(--text-main); color: var(--bg-deep); border: none;
        }
        .btn-internal-primary:hover {
            background: var(--text-muted);
            transform: translateY(-2px);
        }
        .btn-internal-outline {
            background: transparent; color: var(--text-muted);
            border: 1px solid var(--border-steel);
        }
        .btn-internal-outline:hover {
            background: var(--border-steel); color: var(--text-main);
            transform: translateY(-2px);
        }

        /* VIEW ALL PROJECTS pill button */
        .btn-view-all {
            display: inline-flex; align-items: center; gap: 12px;
            margin: 56px auto 0; padding: 18px 52px;
            border: 1px solid var(--border-steel);
            border-radius: 60px; color: var(--text-main);
            font-family: var(--font-heading); font-weight: 800;
            font-size: 0.85rem; letter-spacing: 2.5px; text-transform: uppercase;
            text-decoration: none; background: transparent;
            transition: all 0.4s ease; cursor: pointer;
        }
        .btn-view-all:hover {
            background: var(--text-main); color: var(--bg-deep);
            box-shadow: 0 0 40px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        .portfolio-cta { text-align: center; }

        /* ── PREMIUM VIDEO PLAYER MODAL ── */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
            padding: 24px;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background-color: #FFFFFF;
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            width: 100%;
            max-width: 850px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0,0,0,0.15);
            transform: scale(0.92);
            transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1.1);
        }

        .modal-overlay.active .modal-box { transform: scale(1); }

        .modal-header {
            padding: 25px 35px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title-group h3 {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            color: var(--text-main);
            font-weight: 700;
        }

        .modal-title-group p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .modal-close-trigger {
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close-trigger:hover {
            background: rgba(31,78,107,0.4);
            color: var(--text-main);
        }

        .modal-main-viewport {
            padding: 24px;
            overflow-y: auto;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background: #F9FAFB;
        }
        .modal-main-viewport img { max-width:100%; max-height:60vh; border-radius:10px; object-fit:contain; }
        .modal-main-viewport iframe { width:100%; height:58vh; border:none; border-radius:10px; }

        /* Project split-pane */
        .modal-split-layout { display: flex; flex-direction: column; flex-grow: 1; overflow-y: auto; background-color: #FFFFFF; max-height: 75vh; }
        .modal-gallery-pane { position: relative; background: #F9FAFB; min-height: 450px; width: 100%; flex-shrink: 0; }
        .modal-swiper { width:100%; height:100%; position:absolute; }
        .modal-swiper .swiper-slide { display:flex; align-items:center; justify-content:center; }
        .modal-swiper .swiper-slide img { width:100%; height:100%; object-fit:contain; }
        .modal-swiper .swiper-slide iframe { width:100%; height:100%; border:none; }
        .modal-swiper .swiper-button-next, .modal-swiper .swiper-button-prev {
            color: var(--text-main); background: rgba(8,26,46,0.8);
            border: 1px solid var(--border-steel); width:34px; height:34px; border-radius:6px;
        }
        .modal-swiper .swiper-button-next::after, .modal-swiper .swiper-button-prev::after { font-size:11px; }

        .modal-text-pane { padding: 32px; display: flex; flex-direction: column; background: var(--card-bg); border-top: 1px solid var(--border-steel); }
        .modal-text-pane::-webkit-scrollbar { width: 4px; }
        .modal-text-pane::-webkit-scrollbar-track { background: transparent; }
        .modal-text-pane::-webkit-scrollbar-thumb { background: var(--border-steel); border-radius: 4px; }

        .modal-scrollable-text {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.8;
            margin-bottom: 30px;
            white-space: pre-wrap;
        }

        /* Modern Hamburger Toggle Mobile Menu */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--text-main);
            cursor: pointer;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--glass-border);
            transition: all 0.3s;
            z-index: 1002;
        }

        .mobile-nav-toggle:hover {
            background: rgba(0, 242, 254, 0.05);
            color: var(--accent-cyan);
        }

        /* Footer System */
        footer {
            background-color: #F9FAFB;
            padding: 70px 0;
            text-align: center;
            border-top: 1px solid var(--border-steel);
        }

        footer .logo { justify-content: center; margin-bottom: 25px; color: var(--text-main); }
        footer p { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 10px; }
        footer a { color: var(--text-main); text-decoration: none; font-weight: 600; transition: color 0.3s; }
        footer a:hover { color: var(--text-muted); }

        /* MULTI-DEVICE RESPONSIVE LAYOUT MATRIX */
        @media (max-width: 991px) {
            #hero {
                min-height: auto;
                padding-top: 140px;
                padding-bottom: 80px;
                display: block;
            }
            .hero-layout {
                grid-template-columns: 1fr;
                gap: 55px;
                text-align: center;
            }
            .hero-badge { align-self: center; }
            .hero-image-side { order: -1; }
            .profile-card-wrapper { max-width: 340px; }
            .hero-text-side h1 { font-size: 2.8rem; }
            .hero-role-title { justify-content: center; }
            .hero-role-title::before { display: none; }
            .social-container { flex-direction: column; gap: 15px; }
            
            .floating-pill {
                padding: 8px 16px;
                font-size: 0.75rem;
            }
            .pill-1 { top: 20px; left: 20px; }
            .pill-2 { bottom: 20px; right: 20px; }

            .timeline-container::before { left: 30px; }
            .timeline-pointer { left: 30px; }
            .timeline-bubble { width: calc(100% - 60px); float: right !important; }

            .cert-glass-card { flex: 0 0 calc((100% - 30px) / 2); }
        }

        @media (max-width: 768px) {
            section { padding: 90px 0; }
            .section-header h2 { font-size: 2rem; }
            .mobile-nav-toggle { display: flex; }
            
            .nav-links {
                position: fixed;
                top: 0;
                right: 0;
                transform: translateX(100%);
                width: 80%;
                max-width: 300px;
                height: 100vh;
                background-color: rgba(2, 6, 15, 0.98);
                backdrop-filter: blur(25px);
                -webkit-backdrop-filter: blur(25px);
                flex-direction: column;
                justify-content: center;
                gap: 35px;
                padding: 40px;
                box-shadow: -10px 0 40px rgba(0, 0, 0, 0.6);
                transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                z-index: 1001;
                border-left: 1px solid var(--glass-border);
            }
            .nav-links.active {
                transform: translateX(0);
            }
            
            .cert-glass-card { flex: 0 0 100%; }

            .modal-split-layout { display: flex; flex-direction: column; flex-grow: 1; overflow-y: auto; background-color: #050D18; max-height: 75vh; }
            .modal-gallery-pane { position: relative; background: #030A16; min-height: 450px; width: 100%; flex-shrink: 0; }
            .modal-text-pane { padding: 32px; display: flex; flex-direction: column; background: var(--card-bg); border-top: 1px solid var(--border-steel); }
        }

        @media (max-width: 480px) {
            .hero-text-side h1 { font-size: 2.2rem; }
            .profile-card-wrapper { max-width: 290px; }
            .floating-pill { padding: 6px 12px; font-size: 0.7rem; }
            .pill-1 { top: 15px; left: 15px; }
            .pill-2 { bottom: 15px; right: 15px; }
            .timeline-bubble { padding: 25px; }
        }
    </style>
</head>
<body>

    <div class="glow-blob" style="top: -100px; right: -100px;"></div>
    <div class="glow-blob" style="top: 35%; left: -250px; background: radial-gradient(circle, rgba(79, 172, 254, 0.05) 0%, rgba(3, 10, 22, 0) 70%); animation-delay: -3s;"></div>
    <div class="glow-blob" style="bottom: 10%; right: -200px; background: radial-gradient(circle, rgba(0, 242, 254, 0.05) 0%, rgba(3, 10, 22, 0) 70%); animation-delay: -6s;"></div>

    <header id="navbar">
        <div class="container">
            <nav>
                <a href="#hero" class="logo">
                    <i class="fa-solid fa-clapperboard"></i>
                    <span><?= !empty($name) ? htmlspecialchars($name) : 'PORTFOLIO' ?></span>
                </a>
                
                <ul class="nav-links">
                    <li><a href="#hero">Home</a></li>
                    <?php if (!empty($experiences)): ?>
                        <li><a href="#experiences">Experiences</a></li>
                    <?php endif; ?>
                    <?php if (!empty($certificates)): ?>
                        <li><a href="#certificates">Certificates</a></li>
                    <?php endif; ?>
                    <?php if (!empty($portfolio)): ?>
                        <li><a href="#portfolio">Portfolio</a></li>
                    <?php endif; ?>
                </ul>

                <button class="mobile-nav-toggle" onclick="toggleMobileNav()" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </nav>
        </div>
    </header>

    <section id="hero">
        <div class="container">
            <div class="hero-layout">
                <div class="hero-image-side" data-aos="fade-right" data-aos-duration="1200">
                    <div class="profile-card-wrapper">
                        <div class="profile-inner-frame">
                            <?php if (!empty($photo) && file_exists(__DIR__ . '/files/' . $photo)): ?>
                                <img src="files/<?= htmlspecialchars($photo) ?>" alt="Portrait Profile">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #040d1a; color: var(--accent-cyan)">
                                    <i class="fa-solid fa-user" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                                    <span style="font-size: 0.75rem; letter-spacing: 2px; font-weight: 600;">PROFILE</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="hero-text-side" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="150">
                    <span class="hero-badge">Professional Portfolio</span>
                    <?php if (!empty($name)): ?>
                        <h1>Hello, I'm <span><?= htmlspecialchars($name) ?></span></h1>
                    <?php endif; ?>
                    
                    <?php if (!empty($role)): ?>
                        <div class="hero-role-title"><?= htmlspecialchars($role) ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($description)): ?>
                        <p class="hero-desc"><?= nl2br(htmlspecialchars($description)) ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($socmed)): ?>
                        <div class="social-container">
                            <span class="social-headline">Social Ecosystem</span>
                            <div class="social-flex-row">
                                <?php foreach ($socmed as $s): ?>
                                    <?php if (!empty($s['url']) && !empty($s['icon'])): ?>
                                        <a href="<?= htmlspecialchars($s['url']) ?>" target="_blank" class="social-neon-btn" title="<?= htmlspecialchars($s['platform']) ?>">
                                            <i class="<?= htmlspecialchars($s['icon']) ?>"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($experiences)): ?>
        <section id="experiences">
            <div class="container">
                <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Career <span>Timeline</span></h2>
                    <p>Brief summary of my professional journey, corporate positions, and commercial works.</p>
                </div>
                
                <div class="timeline-container">
                    <?php foreach ($experiences as $idx => $exp): ?>
                        <div class="timeline-node" data-aos="<?= ($idx % 2 === 0) ? 'fade-right' : 'fade-left' ?>" data-aos-duration="1000">
                            <div class="timeline-pointer"></div>
                            <div class="timeline-bubble">
                                <?php if (!empty($exp['year'])): ?>
                                    <span class="timeline-meta-year"><?= htmlspecialchars($exp['year']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($exp['position'])): ?>
                                    <h3 class="timeline-role"><?= htmlspecialchars($exp['position']) ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($exp['company'])): ?>
                                    <div class="timeline-org"><i class="fa-solid fa-building"></i><span><?= htmlspecialchars($exp['company']) ?></span></div>
                                <?php endif; ?>
                                <?php if (!empty($exp['description'])): ?>
                                    <p class="timeline-paragraph"><?= nl2br(htmlspecialchars($exp['description'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($certificates)): ?>
        <section id="certificates">
            <div class="container">
                <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Awards & <span>Credentials</span></h2>
                    <p>Official verifications of my technical skills, masterclasses, and industrial appreciation.</p>
                </div>
                
                <div class="cert-slider-outer" data-aos="fade-up" data-aos-duration="1200">
                    <div class="cert-swiper-container">
                        <div class="cert-slider-track">
                            <?php foreach ($certificates as $index => $cert): ?>
                                <div class="cert-glass-card">
                                    <div>
                                        <div class="cert-asset-box" onclick="openDocModal(<?= $index ?>)">
                                            <?php if (!empty($cert['file']) && file_exists(__DIR__ . '/files/' . $cert['file'])): 
                                                $ext = strtolower(pathinfo($cert['file'], PATHINFO_EXTENSION));
                                                if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                                                    <img src="files/<?= htmlspecialchars($cert['file']) ?>" alt="Credential Document">
                                                <?php elseif ($ext === 'pdf'): ?>
                                                    <div class="cert-thumb-pdf" data-pdf-src="files/<?= htmlspecialchars($cert['file']) ?>" style="width: 100%; height: 100%; position: relative;">
                                                        <canvas class="pdf-canvas" style="width: 100%; display: none;"></canvas>
                                                        <div class="pdf-loading" style="position: absolute; top:50%; left:50%; transform:translate(-50%, -50%); color: var(--text-muted);"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="icon-fallback"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cert-details">
                                            <?php if (!empty($cert['name'])): ?>
                                                <h3><?= htmlspecialchars($cert['name']) ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($cert['issuer'])): ?>
                                                <p><i class="fa-solid fa-signature"></i><span><?= htmlspecialchars($cert['issuer']) ?></span></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <button class="btn-action-trigger" onclick="openDocModal(<?= $index ?>)">
                                        <i class="fa-solid fa-expand"></i><span>EXPAND PREVIEW</span>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="slider-custom-controls">
                        <button class="control-arrow-btn prev" onclick="moveCertSlider(-1)" aria-label="Prev"><i class="fa-solid fa-arrow-left"></i></button>
                        <div class="slider-pills-indicator"></div>
                        <button class="control-arrow-btn next" onclick="moveCertSlider(1)" aria-label="Next"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($portfolio)): ?>
        <section id="portfolio">
            <div class="container">
                <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Project <span>Showcase</span></h2>
                    <p>Explore professional project records, creative developments, and external assets.</p>
                </div>
                
                <div class="portfolio-matrix">
                    <?php 
                    $featured_projects = array_slice($portfolio, 0, 3);
                    foreach ($featured_projects as $proj): 
                        $proj_files = [];
                        if (!empty($proj['files']) && is_array($proj['files'])) {
                            $proj_files = $proj['files'];
                        } elseif (!empty($proj['file'])) {
                            $proj_files = [$proj['file']];
                        }
                        $proj['files'] = $proj_files;
                    ?>
                        <div class="portfolio-neon-card" data-aos="fade-up" data-aos-duration="1000" onclick="openProjectModal(<?= htmlspecialchars(json_encode($proj)) ?>)" style="cursor: pointer;">
                            <div>
                                <div class="portfolio-carousel-viewport">
                                    <div class="swiper project-swiper">
                                        <div class="swiper-wrapper">
                                            <?php if (!empty($proj_files)): ?>
                                                <?php foreach ($proj_files as $file): ?>
                                                    <div class="swiper-slide">
                                                        <?php 
                                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                        if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                                                            <img src="files/<?= htmlspecialchars($file) ?>" alt="Project Capture">
                                                        <?php elseif ($ext === 'pdf'): ?>
                                                            <iframe src="files/<?= htmlspecialchars($file) ?>#page=1&toolbar=0&navpanes=0" scrolling="no"></iframe>
                                                            <div class="asset-shield-overlay"></div>
                                                        <?php else: ?>
                                                            <div class="icon-fallback" style="font-size:3rem; color:var(--text-muted)"><i class="fa-solid fa-image"></i></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="swiper-slide">
                                                    <div class="icon-fallback" style="font-size:3rem; color:var(--text-muted)"><i class="fa-solid fa-folder-open"></i></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (count($proj_files) > 1): ?>
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="portfolio-main-body">
                                    <h3><?= htmlspecialchars($proj['title']) ?></h3>
                                    <p><?= nl2br(htmlspecialchars($proj['description'] ?: '')) ?></p>
                                </div>
                            </div>
                            
                            <div class="portfolio-interactive-footer" onclick="event.stopPropagation()">
                                <button class="btn-internal-action btn-internal-primary" onclick="openProjectModal(<?= htmlspecialchars(json_encode($proj)) ?>)">
                                    <i class="fa-solid fa-cube"></i><span>VIEW DETAILS</span>
                                </button>
                                <?php if (!empty($proj['link'])): ?>
                                    <a href="<?= htmlspecialchars($proj['link']) ?>" target="_blank" class="btn-internal-action btn-internal-outline">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i><span>LAUNCH</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="portfolio-cta" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <a href="projects.php" class="btn-view-all">
                        <i class="fa-solid fa-diagram-project"></i>
                        <span>VIEW ALL PROJECTS</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <footer>
        <div class="container">
            <a href="#hero" class="logo">
                <i class="fa-solid fa-laptop-code"></i>
                <span><?= !empty($name) ? htmlspecialchars($name) : 'Website' ?></span>
            </a>
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($name) ?>. All Rights Reserved.</p>
            <p style="font-size: 0.75rem; opacity: 0.4;"><a href="admin/index.php">Administrator Panel</a></p>
        </div>
    </footer>

    <div class="modal-overlay" id="documentModal" onclick="closeDocModal(event)">
        <button class="cert-modal-nav cert-modal-prev" id="docModalPrev" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: #FFF; border: 1px solid var(--border-steel); color: var(--text-main); font-size: 24px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 2010; transition: all 0.3s;" onclick="navDocModal(-1, event)"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="cert-modal-nav cert-modal-next" id="docModalNext" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: #FFF; border: 1px solid var(--border-steel); color: var(--text-main); font-size: 24px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 2010; transition: all 0.3s;" onclick="navDocModal(1, event)"><i class="fa-solid fa-chevron-right"></i></button>
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title-group">
                    <h3 id="modalDocTitle">Document Object View</h3>
                    <p id="modalDocIssuer">Verification Guild</p>
                </div>
                <button class="modal-close-trigger" onclick="hideDocModal()">&times;</button>
            </div>
            <div class="modal-main-viewport" id="modalDocBody"></div>
        </div>
    </div>

    <div class="modal-overlay" id="projectModal" onclick="closeProjectModal(event)">
        <div class="modal-box" onclick="event.stopPropagation()" style="max-width: 900px;">
            <div class="modal-header">
                <div class="modal-title-group">
                    <h3 id="modalProjTitle">Project Details</h3>
                </div>
                <button class="modal-close-trigger" onclick="hideProjectModal()">&times;</button>
            </div>
            <div class="modal-split-layout">
                <div class="modal-gallery-pane">
                    <div class="swiper modal-swiper">
                        <div class="swiper-wrapper" id="modalSwiperWrapper"></div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <div class="modal-text-pane">
                    <h4 style="font-family: var(--font-heading); color: var(--text-main); font-size: 1.25rem; margin-bottom: 15px;" id="modalProjTitleDetail">Ledger Assignment</h4>
                    <div class="modal-scrollable-text" id="modalProjDesc"></div>
                    <div id="modalProjAction"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        }
        // Initialization Matrix for Internal Card Swiper Sliders
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.project-swiper').forEach(swEl => {
                const sCount = swEl.querySelectorAll('.swiper-slide').length;
                new Swiper(swEl, {
                    loop: sCount > 1,
                    pagination: { el: swEl.querySelector('.swiper-pagination'), clickable: true },
                    navigation: { nextEl: swEl.querySelector('.swiper-button-next'), prevEl: swEl.querySelector('.swiper-button-prev') },
                });
            });
        });

        let currentModalSwiper = null;

        // Open Detailed Project Slide Ledger Modals
        function openProjectModal(proj) {
            const mOverlay = document.getElementById('projectModal');
            document.getElementById('modalProjTitle').textContent = proj.title;
            document.getElementById('modalProjTitleDetail').textContent = proj.title;
            document.getElementById('modalProjDesc').textContent = proj.description || '';
            
            const btnBox = document.getElementById('modalProjAction');
            btnBox.innerHTML = '';
            if (proj.link) {
                btnBox.innerHTML = `
                    <a href="${proj.link}" target="_blank" class="btn-internal-action btn-internal-primary" style="width:100%; text-decoration:none;">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i><span>LAUNCH EXTERNAL WORK</span>
                    </a>`;
            }
            
            const wrapper = document.getElementById('modalSwiperWrapper');
            wrapper.innerHTML = '';
            const files = proj.files || (proj.file ? [proj.file] : []);
            
            if (files.length === 0) {
                wrapper.innerHTML = `<div class="swiper-slide"><div style="color:var(--text-muted)"><i class="fa-solid fa-image-blur"></i> No Tracks</div></div>`;
            } else {
                files.forEach(f => {
                    const ext = f.split('.').pop().toLowerCase();
                    let nodeContent = '';
                    if (['jpg', 'jpeg', 'png'].includes(ext)) {
                        nodeContent = `<img src="files/${f}" alt="Slide Matrix">`;
                    } else if (ext === 'pdf') {
                        nodeContent = `<div class="portfolio-pdf-container" data-pdf-src="files/${f}" style="width:100%; height:100%; overflow-y:auto; position:relative;">
                                         <div class="pdf-loading" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:var(--text-muted);"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></div>
                                       </div>`;
                    } else {
                        nodeContent = `<div style="color:var(--text-muted)"><i class="fa-solid fa-file"></i> Direct view not supported</div>`;
                    }
                    const sDiv = document.createElement('div');
                    sDiv.className = 'swiper-slide';
                    sDiv.innerHTML = nodeContent;
                    wrapper.appendChild(sDiv);
                });
            }
            
            mOverlay.classList.add('active');
            document.body.style.overflow = 'hidden'; document.body.style.paddingRight = (window.innerWidth - document.documentElement.clientWidth) + 'px';
            
            setTimeout(() => {
                if (currentModalSwiper) currentModalSwiper.destroy(true, true);
                currentModalSwiper = new Swiper('.modal-swiper', {
                    loop: files.length > 1,
                    pagination: { el: '.modal-swiper .swiper-pagination', clickable: true },
                    navigation: { nextEl: '.modal-swiper .swiper-button-next', prevEl: '.modal-swiper .swiper-button-prev' },
                });
                renderPortfolioPdfs();
            }, 60);
        }

        function hideProjectModal() {
            document.getElementById('projectModal').classList.remove('active');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            if (currentModalSwiper) {
                currentModalSwiper.destroy(true, true);
                currentModalSwiper = null;
            }
        }

        function closeProjectModal(e) { if (e.target.id === 'projectModal') hideProjectModal(); }

        const certDataList = <?= json_encode(array_values($certificates)) ?>;
        let currentDocIndex = 0;

        // Expand Doc Modal Viewports
        async function openDocModal(index) {
            if (index < 0 || index >= certDataList.length) return;
            currentDocIndex = index;
            const cert = certDataList[index];
            const fUrl = 'files/' + cert.file;
            const title = cert.name;
            const issuer = cert.issuer;

            document.getElementById('modalDocTitle').textContent = title;
            document.getElementById('modalDocIssuer').textContent = "Issuer Authority: " + issuer;
            const body = document.getElementById('modalDocBody');
            body.innerHTML = '<div style="text-align:center; padding: 40px; color: var(--text-muted);"><i class="fa-solid fa-spinner fa-spin fa-2x"></i><p style="margin-top:10px;">Loading Document...</p></div>';
            
            document.getElementById('documentModal').classList.add('active');
            
            // Show or hide next/prev buttons
            document.getElementById('docModalPrev').style.display = certDataList.length > 1 ? 'flex' : 'none';
            document.getElementById('docModalNext').style.display = certDataList.length > 1 ? 'flex' : 'none';

            document.body.style.overflow = 'hidden'; 
            document.body.style.paddingRight = (window.innerWidth - document.documentElement.clientWidth) + 'px';

            const ext = fUrl.split('.').pop().toLowerCase();
            if (ext === 'pdf' && typeof pdfjsLib !== 'undefined') {
                try {
                    const loadingTask = pdfjsLib.getDocument({
                        url: fUrl,
                        cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                        cMapPacked: true,
                        disableAutoFetch: true,
                        disableStream: true
                    });
                    const pdf = await loadingTask.promise;
                    const totalPages = pdf.numPages;
                    
                    const fragment = document.createDocumentFragment();
                    for (let i = 1; i <= totalPages; i++) {
                        const page = await pdf.getPage(i);
                        const desiredWidth = Math.min(window.innerWidth * 0.85, 800);
                        const unscaledVP = page.getViewport({ scale: 1 });
                        const scale = Math.max(1.0, desiredWidth / unscaledVP.width);
                        const viewport = page.getViewport({ scale });

                        const wrapper = document.createElement('div');
                        wrapper.style.marginBottom = '20px';
                        wrapper.style.textAlign = 'center';

                        const canvas = document.createElement('canvas');
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        canvas.style.maxWidth = '100%';
                        canvas.style.height = 'auto';
                        canvas.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';

                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        await page.render({ canvasContext: ctx, viewport }).promise;

                        wrapper.appendChild(canvas);
                        fragment.appendChild(wrapper);
                    }
                    body.innerHTML = '';
                    body.appendChild(fragment);
                } catch (err) {
                    console.error('PDF render failed:', err);
                    body.innerHTML = `<p style="color:var(--danger); text-align:center;">Failed to load PDF.</p>`;
                }
            } else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                body.innerHTML = `<img src="${fUrl}" alt="${title}" style="max-width:100%; height:auto;">`;
            } else {
                body.innerHTML = `<p style="color:var(--text-muted); text-align:center;">Preview format not supported directly.</p>`;
            }
        }

        function hideDocModal() {
            document.getElementById('documentModal').classList.remove('active');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            setTimeout(() => { document.getElementById('modalDocBody').innerHTML = ''; }, 400);
        }

        function closeDocModal(e) { if (e.target.id === 'documentModal') hideDocModal(); }

        function navDocModal(dir, e) {
            if (e) e.stopPropagation();
            let newIndex = currentDocIndex + dir;
            if (newIndex < 0) newIndex = certDataList.length - 1;
            if (newIndex >= certDataList.length) newIndex = 0;
            openDocModal(newIndex);
        }

        async function renderPortfolioPdfs() {
            if (typeof pdfjsLib === 'undefined') return;
            const pdfContainers = document.querySelectorAll('.portfolio-pdf-container[data-pdf-src]');
            
            pdfContainers.forEach(async (container) => {
                const pdfUrl = container.getAttribute('data-pdf-src');
                if (container.dataset.rendered === 'true') return;
                
                try {
                    const loadingTask = pdfjsLib.getDocument({
                        url: pdfUrl,
                        cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                        cMapPacked: true,
                        disableAutoFetch: true,
                        disableStream: true
                    });
                    const pdf = await loadingTask.promise;
                    const totalPages = pdf.numPages;
                    const fragment = document.createDocumentFragment();
                    
                    for (let i = 1; i <= totalPages; i++) {
                        const page = await pdf.getPage(i);
                        const desiredWidth = Math.min(window.innerWidth * 0.85, 800);
                        const unscaledVP = page.getViewport({ scale: 1 });
                        const scale = Math.max(1.0, desiredWidth / unscaledVP.width);
                        const viewport = page.getViewport({ scale });

                        const wrapper = document.createElement('div');
                        wrapper.style.marginBottom = '20px';
                        wrapper.style.textAlign = 'center';

                        const canvas = document.createElement('canvas');
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        canvas.style.maxWidth = '100%';
                        canvas.style.height = 'auto';
                        canvas.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';

                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        await page.render({ canvasContext: ctx, viewport }).promise;

                        wrapper.appendChild(canvas);
                        fragment.appendChild(wrapper);
                    }
                    
                    container.innerHTML = '';
                    container.appendChild(fragment);
                    container.dataset.rendered = 'true';
                } catch (err) {
                    console.error('Portfolio PDF render failed:', err);
                    container.innerHTML = `<p style="padding: 20px; text-align: center; color: var(--danger);">Failed to load PDF.</p>`;
                }
            });
        }

        // Keyboard Esc Key Listener Bindings
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { hideDocModal(); hideProjectModal(); }
        });

        // Mobile Nav Drawer Viewport Interactions
        function toggleMobileNav() {
            const links = document.querySelector('.nav-links');
            const icon = document.querySelector('.mobile-nav-toggle i');
            links.classList.toggle('active');
            icon.className = links.classList.contains('active') ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        }

        document.querySelectorAll('.nav-links a').forEach(a => {
            a.addEventListener('click', () => {
                const links = document.querySelector('.nav-links');
                if (links.classList.contains('active')) {
                    links.classList.remove('active');
                    document.querySelector('.mobile-nav-toggle i').className = 'fa-solid fa-bars';
                }
            });
        });

        // Sticky Scrolling Navbar Transitions
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 40) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // Manual Architectural Engine Calculation for Certificate Sliders
        let currentCertIndex = 0;
        function getCardsPerPage() {
            if (window.innerWidth < 768) return 1;
            if (window.innerWidth < 992) return 2;
            return 3;
        }

        function moveCertSlider(dir) {
            const cards = document.querySelectorAll('.cert-glass-card');
            if (cards.length === 0) return;
            const perPage = getCardsPerPage();
            const maxIdx = Math.max(0, cards.length - perPage);
            currentCertIndex += dir;
            if (currentCertIndex < 0) currentCertIndex = 0;
            if (currentCertIndex > maxIdx) currentCertIndex = maxIdx;
            updateCertSlider();
        }

        function updateCertSlider() {
            const track = document.querySelector('.cert-slider-track');
            const cards = document.querySelectorAll('.cert-glass-card');
            if (cards.length === 0) return;
            const cardW = cards[0].getBoundingClientRect().width;
            const gapVal = 30;
            const transformShift = currentCertIndex * (cardW + gapVal);
            track.style.transform = `translateX(-${transformShift}px)`;
            
            document.querySelectorAll('.slider-pill-dot').forEach((d, idx) => {
                if (idx === currentCertIndex) d.classList.add('active');
                else d.classList.remove('active');
            });

            const prev = document.querySelector('.control-arrow-btn.prev');
            const next = document.querySelector('.control-arrow-btn.next');
            if (prev && next) {
                prev.style.opacity = currentCertIndex === 0 ? '0.25' : '1';
                prev.style.pointerEvents = currentCertIndex === 0 ? 'none' : 'auto';
                const maxIdx = Math.max(0, cards.length - getCardsPerPage());
                next.style.opacity = currentCertIndex === maxIdx ? '0.25' : '1';
                next.style.pointerEvents = currentCertIndex === maxIdx ? 'none' : 'auto';
            }
        }

        function initCertSlider() {
            const container = document.querySelector('.cert-swiper-container');
            if (!container) return;
            const track = document.querySelector('.cert-slider-track');
            const cards = document.querySelectorAll('.cert-glass-card');
            const pillsBox = document.querySelector('.slider-pills-indicator');
            if (!pillsBox) return;
            
            pillsBox.innerHTML = '';
            const perPage = getCardsPerPage();
            const totalSteps = Math.max(0, cards.length - perPage + 1);
            const controls = document.querySelector('.slider-custom-controls');
            
            if (cards.length <= perPage) {
                if (controls) controls.style.display = 'none';
                track.style.transform = 'translateX(0px)';
                return;
            } else if (controls) {
                controls.style.display = 'flex';
            }

            for (let i = 0; i < totalSteps; i++) {
                const pill = document.createElement('div');
                pill.className = 'slider-pill-dot' + (i === 0 ? ' active' : '');
                pill.addEventListener('click', () => { currentCertIndex = i; updateCertSlider(); });
                pillsBox.appendChild(pill);
            }
            currentCertIndex = 0;
            updateCertSlider();
        }

        // Render PDF Thumbnails for slider cards
        function renderPdfThumbnails() {
            if (typeof pdfjsLib !== 'undefined') {
                const pdfNodes = document.querySelectorAll('.cert-thumb-pdf[data-pdf-src]');
                pdfNodes.forEach(async (el) => {
                    const pdfUrl = el.getAttribute('data-pdf-src');
                    const canvas = el.querySelector('.pdf-canvas');
                    const loading = el.querySelector('.pdf-loading');
                    if (!canvas || !pdfUrl) return;

                    try {
                        const loadingTask = pdfjsLib.getDocument({
                            url: pdfUrl,
                            cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                            cMapPacked: true,
                            disableAutoFetch: true,
                            disableStream: true
                        });
                        const pdf = await loadingTask.promise;
                        const page = await pdf.getPage(1);
                        const viewport = page.getViewport({ scale: 1.5 });

                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        const ctx = canvas.getContext('2d');

                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        await page.render({ canvasContext: ctx, viewport }).promise;

                        canvas.style.display = 'block';
                        if (loading) loading.style.display = 'none';
                    } catch (err) {
                        console.warn('PDF thumbnail failed:', pdfUrl, err);
                        if (canvas) canvas.style.display = 'none';
                        if (loading) loading.innerHTML = '<i class="fa-solid fa-file-pdf" style="font-size:2rem; color:var(--text-muted);"></i>';
                    }
                });
            }
        }

        window.addEventListener('DOMContentLoaded', () => { 
            initCertSlider(); 
            renderPdfThumbnails();
            AOS.init({ once: true, offset: 100 }); 
        });
        window.addEventListener('resize', initCertSlider);
    </script>
</body>
</html>