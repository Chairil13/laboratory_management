<?php require_once '../app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/franken-ui@2.1.2/dist/css/core.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/franken-ui@2.1.2/dist/css/utilities.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@0..1&display=block">
<script src="https://cdn.jsdelivr.net/npm/franken-ui@2.1.2/dist/js/core.iife.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/franken-ui@2.1.2/dist/js/icon.iife.js" defer></script>

<style>
    :root {
        --ink: #0b1220;
        --muted: #5f6c7b;
        --line: rgba(15, 23, 42, 0.12);
        --navy: #0b1220;
        --teal: #0f766e;
        --emerald: #047857;
        --red: #b91c1c;
        --gold: #f59e0b;
        --paper: #f7f9fc;
    }

    body {
        background: var(--paper);
    }

    .landing {
        color: var(--ink);
        background:
            linear-gradient(180deg, #ffffff 0%, #f7f9fc 44%, #eef4f3 100%);
        min-height: 100vh;
    }

    .shell {
        width: min(1180px, calc(100% - 40px));
        margin: 0 auto;
    }

    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 70;
        color: #fff;
    }

    .topbar-inner {
        margin-top: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(11, 18, 32, 0.52);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-radius: 8px;
        padding: 10px 12px;
    }

    .brand-mark {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        color: #fff;
        background: linear-gradient(135deg, var(--teal), var(--emerald) 56%, var(--red));
        box-shadow: 0 18px 38px rgba(4, 120, 87, 0.28);
    }

    .hero {
        min-height: 92vh;
        position: relative;
        display: grid;
        align-items: end;
        overflow: hidden;
        background-image:
            linear-gradient(90deg, rgba(6, 11, 23, 0.92) 0%, rgba(6, 11, 23, 0.76) 42%, rgba(6, 11, 23, 0.24) 100%),
            linear-gradient(0deg, rgba(6, 11, 23, 0.94) 0%, rgba(6, 11, 23, 0) 28%),
            url("<?= BASE_URL ?>public/img/logo.png");
        background-size: cover;
        background-position: center;
        color: #fff;
    }

    .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
        background-size: 56px 56px;
        mask-image: linear-gradient(90deg, black, transparent 72%);
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding: 140px 0 42px;
    }

    .hero-copy {
        max-width: 800px;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.24);
        background: rgba(255, 255, 255, 0.11);
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.8rem;
        font-weight: 750;
    }

    .hero h1 {
        margin: 20px 0 22px;
        font-size: clamp(3rem, 7vw, 6.75rem);
        line-height: 0.92;
        letter-spacing: 0;
        font-weight: 850;
    }

    .hero p {
        max-width: 690px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 1.12rem;
        line-height: 1.82;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 30px;
    }

    .uk-btn-primary {
        background: var(--teal);
        border-color: var(--teal);
    }

    .uk-btn-primary:hover {
        background: #0a5e57;
        border-color: #0a5e57;
    }

    .hero-strip {
        margin-top: 58px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .hero-stat {
        min-height: 126px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        padding: 18px;
    }

    .hero-stat strong {
        display: block;
        font-size: 1.85rem;
        line-height: 1;
        margin-bottom: 10px;
    }

    .hero-stat span {
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .section {
        padding: 82px 0;
        border-top: 1px solid var(--line);
    }

    .section-head {
        max-width: 820px;
        margin-bottom: 30px;
    }

    .section-head h2 {
        font-size: clamp(2.2rem, 4vw, 4.2rem);
        line-height: 1.02;
        letter-spacing: 0;
        font-weight: 820;
        margin-bottom: 16px;
    }

    .section-head p {
        color: var(--muted);
        font-size: 1rem;
        line-height: 1.78;
    }

    .workflow {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .workflow-card,
    .content-card,
    .contact-card {
        border-radius: 8px;
        border: 1px solid rgba(15, 23, 42, 0.1);
        background: rgba(255, 255, 255, 0.82);
        box-shadow: 0 18px 52px rgba(15, 23, 42, 0.07);
    }

    .workflow-card {
        padding: 24px;
        min-height: 260px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .workflow-card:nth-child(2) {
        background: #0b1220;
        color: #fff;
    }

    .workflow-card:nth-child(2) p {
        color: rgba(255, 255, 255, 0.68);
    }

    .icon-box {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        background: rgba(15, 118, 110, 0.11);
        color: var(--teal);
    }

    .workflow-card:nth-child(2) .icon-box {
        background: rgba(245, 158, 11, 0.16);
        color: var(--gold);
    }

    .workflow-card h3 {
        margin: 18px 0 10px;
        font-size: 1.25rem;
        font-weight: 780;
    }

    .workflow-card p {
        color: var(--muted);
        line-height: 1.72;
    }

    .split {
        display: grid;
        grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.08fr);
        gap: 18px;
        align-items: stretch;
    }

    .content-card {
        padding: 28px;
    }

    .dark-panel {
        background: var(--navy);
        color: #fff;
    }

    .dark-panel p,
    .dark-panel li {
        color: rgba(255, 255, 255, 0.72);
    }

    .timeline {
        display: grid;
        gap: 12px;
        margin-top: 22px;
    }

    .timeline-item {
        display: grid;
        grid-template-columns: 88px 1fr;
        gap: 14px;
        padding: 14px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .timeline-item strong {
        color: #fff;
    }

    .program-grid {
        display: grid;
        gap: 12px;
        margin-top: 22px;
    }

    .program {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        border-radius: 8px;
        border: 1px solid rgba(15, 23, 42, 0.1);
        background: #fff;
        padding: 14px;
    }

    .program strong {
        display: block;
        margin-bottom: 4px;
    }

    .program span {
        color: var(--muted);
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .contact-band {
        background: #ffffff;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: minmax(0, 0.86fr) minmax(0, 1.14fr);
        gap: 18px;
    }

    .contact-card {
        padding: 24px;
    }

    .contact-list {
        display: grid;
        gap: 12px;
        margin-top: 18px;
    }

    .contact-item {
        display: grid;
        grid-template-columns: 42px 1fr;
        gap: 12px;
        align-items: start;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.08);
        padding: 14px;
    }

    .map-panel {
        min-height: 390px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(15, 23, 42, 0.1);
        background:
            linear-gradient(135deg, rgba(15, 118, 110, 0.9), rgba(11, 18, 32, 0.96)),
            url("<?= BASE_URL ?>public/img/logo.png");
        background-size: cover;
        background-position: center;
        color: #fff;
        padding: 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .map-panel p {
        color: rgba(255, 255, 255, 0.74);
        max-width: 540px;
        line-height: 1.7;
    }

    .footer {
        padding: 30px 0 38px;
        color: var(--muted);
        border-top: 1px solid var(--line);
        background: #fff;
    }

    @media (max-width: 980px) {
        .hero {
            min-height: auto;
        }

        .hero-strip,
        .workflow,
        .split,
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .hero-content {
            padding-top: 126px;
        }
    }

    @media (max-width: 660px) {
        .shell {
            width: min(100% - 24px, 1180px);
        }

        .topbar nav {
            display: none;
        }

        .hero h1 {
            font-size: 3rem;
        }

        .hero-actions .uk-btn {
            width: 100%;
            justify-content: center;
        }

        .timeline-item {
            grid-template-columns: 1fr;
        }
    }

    /* Retro classic restyle */
    :root {
        --retro-ink: #24180f;
        --retro-muted: #765f48;
        --retro-line: rgba(73, 49, 29, 0.25);
        --retro-green: #173b34;
        --retro-teal: #1f6b5c;
        --retro-red: #9f2f28;
        --retro-gold: #c4892d;
        --retro-paper: #f3e6cf;
        --retro-cream: #fff6df;
        --retro-coffee: #3b2417;
    }

    .landing {
        color: var(--retro-ink);
        background:
            radial-gradient(circle at 18px 18px, rgba(59, 36, 23, 0.08) 1.5px, transparent 1.5px),
            linear-gradient(90deg, rgba(159, 47, 40, 0.08), transparent 28%, rgba(31, 107, 92, 0.09)),
            var(--retro-paper);
        background-size: 24px 24px, auto, auto;
        font-family: Georgia, 'Times New Roman', serif;
    }

    .landing .material-symbols-outlined,
    .landing .icon-box .material-symbols-outlined,
    .landing .ledger-dot .material-symbols-outlined {
        font-family: 'Material Symbols Outlined' !important;
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        line-height: 1;
        letter-spacing: 0;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-feature-settings: 'liga';
        font-feature-settings: 'liga';
        -webkit-font-smoothing: antialiased;
        font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
    }

    .topbar-inner {
        border: 2px solid rgba(255, 246, 223, 0.86);
        background: rgba(36, 24, 15, 0.86);
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        box-shadow: 7px 7px 0 rgba(36, 24, 15, 0.3);
    }

    .brand-mark {
        color: var(--retro-cream);
        background: var(--retro-red);
        border: 2px solid var(--retro-cream);
        box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.22);
    }

    .hero {
        color: var(--retro-cream);
        border-bottom: 12px solid var(--retro-coffee);
        background-image:
            linear-gradient(90deg, rgba(36, 24, 15, 0.95) 0%, rgba(36, 24, 15, 0.82) 43%, rgba(36, 24, 15, 0.34) 100%),
            linear-gradient(0deg, rgba(36, 24, 15, 0.98) 0%, rgba(36, 24, 15, 0) 30%),
            url("<?= BASE_URL ?>public/img/logo.png");
    }

    .hero::after {
        background-image:
            radial-gradient(circle, rgba(255, 246, 223, 0.22) 1px, transparent 1px),
            linear-gradient(rgba(255, 246, 223, 0.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 246, 223, 0.08) 1px, transparent 1px);
        background-size: 9px 9px, 58px 58px, 58px 58px;
        mask-image: none;
        opacity: 0.56;
    }

    .hero-copy {
        position: relative;
    }

    .hero.hero {
        background-image:
            linear-gradient(90deg, rgba(36, 24, 15, 0.96) 0%, rgba(36, 24, 15, 0.88) 43%, rgba(20, 44, 77, 0.72) 100%),
            linear-gradient(0deg, rgba(36, 24, 15, 0.98) 0%, rgba(36, 24, 15, 0) 30%),
            url("<?= BASE_URL ?>public/img/logo.png");
        background-size: auto, auto, min(36vw, 520px);
        background-repeat: no-repeat;
        background-position: center, center, center center;
        background-blend-mode: normal, normal, luminosity;
    }

    .eyebrow {
        border-radius: 8px;
        border: 2px solid rgba(255, 246, 223, 0.78);
        background: rgba(159, 47, 40, 0.86);
        color: var(--retro-cream);
        font-family: Inter, sans-serif;
        font-size: 0.76rem;
        text-transform: uppercase;
        box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.24);
    }

    .hero h1,
    .section-head h2 {
        font-weight: 900;
        letter-spacing: 0;
    }

    .hero h1 {
        font-size: clamp(3.2rem, 7.4vw, 7.5rem);
        line-height: 0.88;
        text-shadow: 5px 5px 0 rgba(0, 0, 0, 0.36);
    }

    .hero p,
    .hero-stat span,
    .section-head p,
    .workflow-card p,
    .program span,
    .timeline-item,
    .contact-item,
    .map-panel p,
    .footer {
        font-family: Inter, sans-serif;
    }

    .hero p,
    .hero-stat span {
        color: rgba(255, 246, 223, 0.8);
    }

    .transaction-board {
        position: relative;
        min-height: 360px;
        border: 2px solid rgba(255, 246, 223, 0.84);
        border-radius: 8px;
        background:
            linear-gradient(rgba(59, 36, 23, 0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 36, 23, 0.06) 1px, transparent 1px),
            rgba(255, 246, 223, 0.74);
        background-size: 22px 22px;
        box-shadow: 10px 10px 0 rgba(59, 36, 23, 0.22);
        padding: 22px;
        overflow: hidden;
        color: var(--retro-coffee);
    }

    .transaction-board::before {
        content: "PROCESS NO. SLMS-2026";
        position: absolute;
        top: 16px;
        right: 18px;
        color: rgba(59, 36, 23, 0.26);
        font-family: Inter, sans-serif;
        font-size: 0.78rem;
        font-weight: 900;
    }

    .ledger-title {
        font-family: Inter, sans-serif;
        text-transform: uppercase;
        color: var(--retro-red);
        font-size: 0.74rem;
        font-weight: 900;
        margin-bottom: 18px;
    }

    .ledger-track {
        position: relative;
        display: grid;
        gap: 18px;
        padding-left: 18px;
        margin-right: 260px;
    }

    .ledger-track::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 18px;
        bottom: 18px;
        width: 2px;
        background: rgba(59, 36, 23, 0.25);
    }

    .ledger-step {
        position: relative;
        display: grid;
        grid-template-columns: 42px 1fr;
        gap: 12px;
        align-items: center;
        opacity: 0.54;
        transform: translateX(16px);
        animation: ledgerStep 7.2s infinite;
    }

    .ledger-step:nth-child(2) {
        animation-delay: 1.8s;
    }

    .ledger-step:nth-child(3) {
        animation-delay: 3.6s;
    }

    .ledger-dot {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        border: 2px solid var(--retro-coffee);
        color: var(--retro-coffee);
        background: var(--retro-gold);
        box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.24);
        z-index: 2;
    }

    .ledger-card {
        border: 2px solid var(--retro-coffee);
        border-radius: 8px;
        background: rgba(255, 246, 223, 0.92);
        color: var(--retro-coffee);
        padding: 13px;
        font-family: Inter, sans-serif;
        box-shadow: 6px 6px 0 rgba(59, 36, 23, 0.18);
        min-height: 72px;
    }

    .ledger-card strong {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 0.92rem;
    }

    .ledger-card span {
        display: block;
        margin-top: 7px;
        color: #6d5136;
        font-size: 0.78rem;
        line-height: 1.5;
    }

    .moving-slip {
        position: absolute;
        right: 28px;
        top: 74px;
        width: min(230px, calc(100% - 56px));
        border: 2px solid var(--retro-coffee);
        border-radius: 8px;
        background: var(--retro-cream);
        color: var(--retro-coffee);
        box-shadow: 8px 8px 0 rgba(59, 36, 23, 0.24);
        padding: 12px;
        font-family: Inter, sans-serif;
        animation: borrowSlip 7.2s infinite;
        z-index: 3;
    }

    .moving-slip::before {
        content: "";
        display: block;
        height: 8px;
        margin: -14px -14px 12px;
        background: repeating-linear-gradient(90deg, var(--retro-red) 0 18px, var(--retro-gold) 18px 36px, var(--retro-teal) 36px 54px);
        border-radius: 6px 6px 0 0;
    }

    .slip-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        border-bottom: 1px dashed rgba(59, 36, 23, 0.35);
        padding: 7px 0;
        font-size: 0.7rem;
    }

    .slip-row strong {
        color: var(--retro-red);
    }

    @keyframes ledgerStep {
        0%, 16% {
            opacity: 0.54;
            transform: translateX(16px);
        }
        23%, 42% {
            opacity: 1;
            transform: translateX(0);
        }
        54%, 100% {
            opacity: 0.62;
            transform: translateX(0);
        }
    }

    @keyframes borrowSlip {
        0%, 14% {
            transform: translate(0, 0) rotate(-2deg);
        }
        30%, 42% {
            transform: translate(0, 96px) rotate(1deg);
        }
        58%, 72% {
            transform: translate(0, 192px) rotate(-1deg);
        }
        88%, 100% {
            transform: translate(0, 0) rotate(-2deg);
        }
    }


    .uk-btn-primary {
        background: var(--retro-red);
        border: 2px solid var(--retro-coffee);
        color: var(--retro-cream);
        box-shadow: 5px 5px 0 var(--retro-coffee);
    }

    .uk-btn-primary:hover {
        background: #7f251f;
        border-color: var(--retro-coffee);
        color: var(--retro-cream);
    }

    .uk-btn-default,
    .uk-btn-secondary {
        border: 2px solid var(--retro-coffee);
        background: var(--retro-cream);
        color: var(--retro-coffee);
        box-shadow: 5px 5px 0 rgba(59, 36, 23, 0.82);
    }

    .hero-stat,
    .workflow-card,
    .content-card,
    .contact-card,
    .program {
        border: 2px solid var(--retro-coffee);
        border-radius: 8px;
        box-shadow: 8px 8px 0 rgba(59, 36, 23, 0.22);
    }

    .hero-stat {
        background: rgba(255, 246, 223, 0.13);
        border-color: rgba(255, 246, 223, 0.75);
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }

    .hero-stat strong,
    .timeline-item strong {
        color: #ffd486;
    }

    .section {
        border-top: 3px double rgba(59, 36, 23, 0.28);
    }

    .section-head h2 {
        color: var(--retro-coffee);
        line-height: 0.98;
    }

    .section-head p,
    .workflow-card p,
    .program span {
        color: var(--retro-muted);
    }

    .workflow-card,
    .content-card,
    .contact-card,
    .program {
        background: var(--retro-cream);
    }

    .workflow-card:nth-child(2),
    .dark-panel {
        background: var(--retro-green);
        color: var(--retro-cream);
    }

    .workflow-card:nth-child(2) p,
    .dark-panel p,
    .dark-panel li {
        color: rgba(255, 246, 223, 0.76);
    }

    .icon-box {
        background: #e2c891;
        color: var(--retro-coffee);
        border: 2px solid var(--retro-coffee);
        box-shadow: 4px 4px 0 rgba(59, 36, 23, 0.18);
    }

    .retro-glyph {
        font-family: Inter, sans-serif;
        font-size: 0.84rem;
        font-weight: 900;
        line-height: 1;
        color: var(--retro-coffee);
    }

    .workflow-card:nth-child(2) .icon-box {
        background: var(--retro-gold);
        color: var(--retro-coffee);
    }

    .timeline-item {
        background: rgba(255, 246, 223, 0.1);
        border: 1px solid rgba(255, 246, 223, 0.22);
    }

    .contact-band {
        background:
            linear-gradient(rgba(59, 36, 23, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 36, 23, 0.05) 1px, transparent 1px),
            #ead8b9;
        background-size: 28px 28px;
    }

    .contact-item {
        background: rgba(255, 246, 223, 0.72);
        border: 2px solid rgba(59, 36, 23, 0.22);
    }

    .map-panel {
        border: 2px solid var(--retro-coffee);
        background:
            linear-gradient(135deg, rgba(23, 59, 52, 0.94), rgba(59, 36, 23, 0.93)),
            url("<?= BASE_URL ?>public/img/logo.png");
        background-size: auto, 220px;
        background-repeat: no-repeat;
        background-position: center, right 28px center;
        color: var(--retro-cream);
        box-shadow: 10px 10px 0 rgba(59, 36, 23, 0.28);
    }

    .footer {
        background: var(--retro-cream);
        border-top: 3px double rgba(59, 36, 23, 0.28);
    }

    .uk-badge {
        border-radius: 8px;
        border: 1px solid var(--retro-coffee);
        font-family: Inter, sans-serif;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    .retro-stamp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 150px;
        height: 150px;
        border: 3px double rgba(255, 246, 223, 0.9);
        border-radius: 50%;
        color: #ffd486;
        font-family: Inter, sans-serif;
        font-size: 0.76rem;
        font-weight: 900;
        text-align: center;
        text-transform: uppercase;
        transform: rotate(-9deg);
        position: absolute;
        right: -120px;
        top: 12px;
        background: rgba(159, 47, 40, 0.38);
        box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.22);
    }

    @media (max-width: 660px) {
        .retro-stamp {
            position: static;
            margin-top: 20px;
            width: 116px;
            height: 116px;
        }
    }

    @media (max-width: 980px) {
        .hero.hero {
            background-size: auto, auto, 320px;
            background-position: center, center, center 150px;
        }
    }

    @media (max-width: 660px) {
        .transaction-board {
            min-height: 560px;
        }

        .ledger-track {
            margin-right: 0;
        }

        .moving-slip {
            top: auto;
            right: 18px;
            bottom: 22px;
            width: calc(100% - 36px);
            animation: slipMobile 7.2s infinite;
        }
    }

    @keyframes slipMobile {
        0%, 14% {
            transform: translateY(0) rotate(-1deg);
        }
        30%, 42% {
            transform: translateY(-8px) rotate(1deg);
        }
        58%, 72% {
            transform: translateY(8px) rotate(-1deg);
        }
        88%, 100% {
            transform: translateY(0) rotate(-1deg);
        }
    }
</style>

<div class="landing">
    <header class="topbar">
        <div class="shell topbar-inner flex items-center justify-between gap-4">
            <a href="<?= BASE_URL ?>" class="flex items-center gap-3 no-underline text-white">
                <span class="brand-mark">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">science</span>
                </span>
                <span>
                    <span class="block text-sm font-bold">Smart Lab MS</span>
                    <span class="block text-xs opacity-70">Electrical Engineering Laboratory</span>
                </span>
            </a>
            <nav class="flex items-center gap-6 text-sm font-medium text-white/75">
                <a class="hover:text-white" href="#alur">Alur</a>
                <a class="hover:text-white" href="#polnam">Polnam</a>
                <a class="hover:text-white" href="#elektro">Teknik Elektro</a>
                <a class="hover:text-white" href="#kontak">Kontak</a>
            </nav>
            <a class="uk-btn uk-btn-primary rounded-md" href="<?= BASE_URL ?>auth/login">
                <span class="material-symbols-outlined text-base">login</span>
                Masuk
            </a>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="shell hero-content">
                <div class="hero-copy">
                    <span class="eyebrow">
                        <span class="material-symbols-outlined text-base">inventory_2</span>
                        Arsip Peminjaman Alat Laboratorium
                    </span>
                    <span class="retro-stamp">Electrical<br>Lab<br>Catalog</span>
                    <h1>Katalog alat lab, rasa klasik yang tetap gesit.</h1>
                    <p>
                        Smart Lab MS membawa gaya katalog laboratorium klasik ke alur digital: peminjaman alat, approval, pengembalian, dan histori asset Laboratorium Jurusan Teknik Elektro Politeknik Negeri Ambon.
                    </p>
                    <div class="hero-actions">
                        <a class="uk-btn uk-btn-primary rounded-md" href="<?= BASE_URL ?>auth/login">
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                            Masuk ke Sistem
                        </a>
                        <a class="uk-btn uk-btn-default rounded-md" href="#alur">
                            <span class="material-symbols-outlined text-base">route</span>
                            Lihat Alur Peminjaman
                        </a>
                    </div>
                </div>

                <div class="hero-strip">
                    <div class="hero-stat">
                        <strong>01</strong>
                        <span>Pilih alat berdasarkan kebutuhan praktikum atau kegiatan laboratorium.</span>
                    </div>
                    <div class="hero-stat">
                        <strong>02</strong>
                        <span>Ajukan peminjaman dengan data peminjam dan tanggal penggunaan.</span>
                    </div>
                    <div class="hero-stat">
                        <strong>03</strong>
                        <span>Petugas memeriksa stok dan memberi approval secara digital.</span>
                    </div>
                    <div class="hero-stat">
                        <strong>04</strong>
                        <span>Pengembalian diverifikasi agar kondisi asset tetap terdokumentasi.</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="alur" class="section">
            <div class="shell">
                <div class="section-head">
                    <span class="uk-badge uk-badge-primary">Laboratory Workflow</span>
                    <h2 class="mt-4">Seperti kartu katalog, tapi hidup.</h2>
                    <p>Sistem ini dibuat supaya peminjaman alat tidak tercecer di kertas, chat pribadi, atau catatan manual. Setiap proses punya status, waktu, dan bukti yang bisa ditelusuri.</p>
                </div>

                <div class="workflow">
                    <article class="workflow-card">
                        <div>
                            <span class="icon-box"><span class="material-symbols-outlined">widgets</span></span>
                            <h3>Inventaris terbaca</h3>
                            <p>Pengguna langsung memahami bahwa web ini berisi daftar alat, kategori, stok, dan informasi asset laboratorium.</p>
                        </div>
                        <span class="uk-badge uk-badge-secondary w-fit">Asset</span>
                    </article>
                    <article class="workflow-card">
                        <div>
                            <span class="icon-box"><span class="material-symbols-outlined">task_alt</span></span>
                            <h3>Persetujuan rapi</h3>
                            <p>Admin dan petugas laboratorium dapat melihat permintaan, mengecek kebutuhan, lalu menyetujui atau menolak pengajuan.</p>
                        </div>
                        <span class="uk-badge w-fit">Persetujuan</span>
                    </article>
                    <article class="workflow-card">
                        <div>
                            <span class="icon-box"><span class="material-symbols-outlined">assignment_return</span></span>
                            <h3>Pengembalian tercatat</h3>
                            <p>Pengembalian alat tidak hanya selesai secara lisan, tetapi masuk ke riwayat dan kondisi barang bisa diverifikasi.</p>
                        </div>
                        <span class="uk-badge uk-badge-secondary w-fit">Pengembalian</span>
                    </article>
                </div>

                <aside class="transaction-board mt-8" aria-label="Animasi transaksi peminjaman alat">
                    <div class="ledger-title">Simulasi Transaksi Peminjaman</div>
                    <div class="ledger-track">
                        <div class="ledger-step">
                            <span class="ledger-dot"><span class="material-symbols-outlined">edit_note</span></span>
                            <div class="ledger-card">
                                <strong>Request <small>#LAB-026</small></strong>
                                <span>Mahasiswa mengajukan peminjaman multimeter digital.</span>
                            </div>
                        </div>
                        <div class="ledger-step">
                            <span class="ledger-dot"><span class="material-symbols-outlined">verified</span></span>
                            <div class="ledger-card">
                                <strong>Disetujui <small>Teknisi</small></strong>
                                <span>Petugas memeriksa stok dan menyetujui penggunaan.</span>
                            </div>
                        </div>
                        <div class="ledger-step">
                            <span class="ledger-dot"><span class="material-symbols-outlined">assignment_return</span></span>
                            <div class="ledger-card">
                                <strong>Dikembalikan <small>Selesai</small></strong>
                                <span>Alat kembali, kondisi dicatat, histori tersimpan.</span>
                            </div>
                        </div>
                    </div>

                    <div class="moving-slip" aria-hidden="true">
                        <div class="slip-row"><span>Asset</span><strong>Multimeter</strong></div>
                        <div class="slip-row"><span>Peminjam</span><strong>Teknik Elektro</strong></div>
                        <div class="slip-row"><span>Status</span><strong>Diproses</strong></div>
                        <div class="slip-row"><span>Ledger</span><strong>#SLMS-2026</strong></div>
                    </div>
                </aside>
            </div>
        </section>

        <section id="polnam" class="section">
            <div class="shell split">
                <article class="content-card dark-panel">
                    <span class="uk-badge uk-badge-secondary">Politeknik Negeri Ambon</span>
                    <h2 class="mt-5 text-4xl font-bold leading-tight">Kampus vokasi teknologi terapan di Maluku.</h2>
                    <p class="mt-4 leading-8">
                        Polnam adalah perguruan tinggi negeri vokasi pertama di Maluku dan satu-satunya di Kota Ambon. Polnam mempersiapkan lulusan terampil yang siap pakai, mampu berwirausaha, dan berperan langsung di dunia kerja.
                    </p>
                    <div class="timeline">
                        <div class="timeline-item">
                            <strong>1982</strong>
                            <span>Awal pendirian sebagai Politeknik Universitas Pattimura Ambon.</span>
                        </div>
                        <div class="timeline-item">
                            <strong>1987</strong>
                            <span>Perkuliahan pertama dimulai setelah pembangunan gedung, laboratorium, kantor, dan peralatan.</span>
                        </div>
                        <div class="timeline-item">
                            <strong>1998</strong>
                            <span>Berstatus mandiri dan berganti nama menjadi Politeknik Negeri Ambon.</span>
                        </div>
                    </div>
                </article>

                <article class="content-card">
                    <span class="icon-box"><span class="material-symbols-outlined">hub</span></span>
                    <h2 class="mt-5 text-4xl font-bold leading-tight">Peminjaman alat dengan karakter akademik.</h2>
                    <p class="mt-4 text-gray-600 leading-8">
                        Karena Polnam bergerak di pendidikan vokasi dan teknologi terapan, sistem peminjaman alat laboratorium perlu terasa seperti bagian dari ekosistem kerja praktik: cepat, jelas, dan siap dipakai berulang kali.
                    </p>
                    <div class="grid gap-3 mt-6 md:grid-cols-2">
                        <div class="p-4 bg-slate-50 border rounded-lg">
                            <strong class="block text-2xl">5</strong>
                            <span class="text-sm text-gray-500">Jurusan utama Polnam</span>
                        </div>
                        <div class="p-4 bg-slate-50 border rounded-lg">
                            <strong class="block text-2xl">13</strong>
                            <span class="text-sm text-gray-500">Program studi di profil resmi</span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section id="elektro" class="section">
            <div class="shell">
                <div class="section-head">
                    <span class="uk-badge uk-badge-primary">Electrical Engineering Dept.</span>
                    <h2 class="mt-4">Teknik Elektro, energi klasik untuk kerja modern.</h2>
                    <p>Teknik Elektro termasuk jurusan awal Polnam. Pada Program Studi Teknik Listrik D3, Polnam menekankan pendidikan profesional berbasis kompetensi, kelistrikan terapan, teknologi terkini, dan kualifikasi nasional maupun internasional.</p>
                </div>

                <div class="program-grid">
                    <div class="program">
                        <span class="icon-box"><span class="retro-glyph">V</span></span>
                        <div>
                            <strong>Teknik Listrik - Diploma Tiga (D3)</strong>
                            <span>Fokus pada kompetensi kelistrikan terapan dan praktik laboratorium.</span>
                        </div>
                    </div>
                    <div class="program">
                        <span class="icon-box"><span class="retro-glyph">{ }</span></span>
                        <div>
                            <strong>Teknik Informatika - Sarjana Terapan (D4)</strong>
                            <span>Menguatkan sisi sistem digital, data, dan layanan berbasis teknologi.</span>
                        </div>
                    </div>
                    <div class="program">
                        <span class="icon-box"><span class="retro-glyph">O/G</span></span>
                        <div>
                            <strong>Teknologi Rekayasa Sistem Kelistrikan Minyak dan Gas - Sarjana Terapan (D4)</strong>
                            <span>Menghubungkan kompetensi kelistrikan dengan kebutuhan industri energi.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="section contact-band">
            <div class="shell contact-grid">
                <article class="contact-card">
                    <span class="uk-badge uk-badge-primary">Kontak Resmi</span>
                    <h2 class="mt-4 text-4xl font-bold leading-tight">Butuh informasi kampus?</h2>
                    <p class="mt-4 text-gray-600 leading-8">Gunakan kontak resmi Politeknik Negeri Ambon untuk informasi institusi. Untuk akses sistem peminjaman alat, gunakan tombol masuk dan login sesuai akun yang tersedia.</p>

                    <div class="contact-list">
                        <div class="contact-item">
                            <span class="icon-box"><span class="material-symbols-outlined">location_on</span></span>
                            <div>
                                <strong>Alamat</strong>
                                <p class="m-0 text-sm text-gray-600 leading-6">Jl. Ir. M. Putuhena, Wailela, Rumahtiga, Kec. Teluk Ambon, Kota Ambon, Provinsi Maluku</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="icon-box"><span class="material-symbols-outlined">mail</span></span>
                            <div>
                                <strong>Email</strong>
                                <p class="m-0 text-sm text-gray-600">info@polnam.ac.id</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="icon-box"><span class="material-symbols-outlined">language</span></span>
                            <div>
                                <strong>Website</strong>
                                <p class="m-0 text-sm text-gray-600">https://polnam.ac.id</p>
                            </div>
                        </div>
                    </div>
                </article>

                <aside class="map-panel">
                    <div>
                        <span class="uk-badge uk-badge-secondary">Ambon, Maluku</span>
                        <h2 class="mt-5 text-5xl font-bold leading-tight">Rumahtiga, Teluk Ambon</h2>
                        <p class="mt-4">
                            Halaman ini mengarahkan mahasiswa dan civitas ke sistem peminjaman alat, sekaligus memperkenalkan konteks kampus dan Jurusan Teknik Elektro sebelum mereka login.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a class="uk-btn uk-btn-default rounded-md" href="<?= BASE_URL ?>auth/login">
                            <span class="material-symbols-outlined text-base">login</span>
                            Masuk Sistem
                        </a>
                        <a class="uk-btn uk-btn-secondary rounded-md" href="https://polnam.ac.id" target="_blank" rel="noopener">
                            <span class="material-symbols-outlined text-base">open_in_new</span>
                            Web Polnam
                        </a>
                    </div>
                </aside>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="shell flex flex-wrap items-center justify-between gap-3 text-sm">
            <span>&copy; 2026 Electrical Engineering Dept. Technical Laboratory System</span>
            <span>Sistem Manajemen Laboratorium Cerdas</span>
        </div>
    </footer>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>



