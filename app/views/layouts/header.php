<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dasbor' ?> - Smart Lab MS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Symbols - Outlined (thin) -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,200,0,0&display=swap" rel="stylesheet">
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        'glass': 'rgba(255, 255, 255, 0.15)',
                        'glass-border': 'rgba(255, 255, 255, 0.25)'
                    },
                    backdropBlur: {
                        'xs': '2px',
                        'glass': '20px'
                    }
                }
            }
        }
    </script>
    
    <style>
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

        /* Retro classic utilities */
        .glass-card {
            background: var(--retro-cream) !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: 2px solid var(--retro-coffee) !important;
            box-shadow: 7px 7px 0 rgba(59, 36, 23, 0.2) !important;
        }
        
        .glass-sidebar {
            background:
                linear-gradient(rgba(255, 246, 223, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 246, 223, 0.04) 1px, transparent 1px),
                var(--retro-green) !important;
            background-size: 22px 22px;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border-right: 3px solid var(--retro-coffee);
            box-shadow: 8px 0 0 rgba(59, 36, 23, 0.18);
        }
        
        .glass-stat {
            background: var(--retro-cream) !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: 2px solid var(--retro-coffee) !important;
            box-shadow: 8px 8px 0 rgba(59, 36, 23, 0.2) !important;
        }
        
        /* Form input styling with better contrast */
        .form-input {
            background: rgba(255, 246, 223, 0.88) !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: 2px solid rgba(59, 36, 23, 0.32) !important;
            color: var(--retro-ink) !important;
        }
        
        .form-input:hover {
            border-color: rgba(59, 36, 23, 0.55) !important;
        }
        
        .form-input:focus {
            background: var(--retro-cream) !important;
            border-color: var(--retro-red) !important;
            box-shadow: 0 0 0 3px rgba(159, 47, 40, 0.14) !important;
        }
        
        /* Smooth animations */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 10px 10px 0 rgba(59, 36, 23, 0.24) !important;
        }
        
        .hover-glow:hover {
            box-shadow: 10px 10px 0 rgba(59, 36, 23, 0.24) !important;
        }
        
        /* Material icons thin */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 200, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Gradient background */
        body {
            background:
                radial-gradient(circle at 18px 18px, rgba(59, 36, 23, 0.08) 1.5px, transparent 1.5px),
                linear-gradient(90deg, rgba(159, 47, 40, 0.06), transparent 32%, rgba(31, 107, 92, 0.08)),
                var(--retro-paper);
            background-size: 24px 24px, auto, auto;
            min-height: 100vh;
            color: var(--retro-ink);
        }

        h1, h2, h3 {
            font-family: Georgia, 'Times New Roman', serif;
            letter-spacing: 0;
            color: var(--retro-coffee);
        }

        main {
            color: var(--retro-ink);
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        thead {
            background: rgba(226, 200, 145, 0.36);
        }

        th {
            color: var(--retro-coffee) !important;
            font-weight: 800 !important;
        }

        td {
            color: var(--retro-ink);
        }

        tbody tr:hover {
            background: rgba(226, 200, 145, 0.22) !important;
        }

        input, select, textarea {
            border-radius: 8px !important;
        }

        .bg-white,
        .bg-surface {
            background: var(--retro-cream) !important;
        }

        .border-gray-200,
        .border-gray-100,
        .border-border,
        .border {
            border-color: rgba(59, 36, 23, 0.25) !important;
        }

        .shadow-sm,
        .shadow-lg,
        .shadow-xl,
        .shadow-2xl {
            box-shadow: 7px 7px 0 rgba(59, 36, 23, 0.16) !important;
        }

        .rounded-3xl,
        .rounded-2xl,
        .rounded-xl {
            border-radius: 8px !important;
        }

        a[class*="bg-gradient-to-r"],
        button[class*="bg-gradient-to-r"],
        .btn-signin,
        .btn-register {
            background: var(--retro-red) !important;
            border: 2px solid var(--retro-coffee) !important;
            color: var(--retro-cream) !important;
            box-shadow: 5px 5px 0 var(--retro-coffee) !important;
        }

        [class*="from-emerald"],
        [class*="to-emerald"],
        [class*="from-violet"],
        [class*="to-violet"],
        [class*="from-amber"],
        [class*="to-amber"],
        [class*="from-slate"],
        [class*="to-slate"],
        [class*="from-gray"],
        [class*="to-gray"],
        [class*="from-blue"],
        [class*="to-blue"],
        [class*="from-cyan"],
        [class*="to-cyan"] {
            --tw-gradient-from: var(--retro-gold) !important;
            --tw-gradient-to: var(--retro-red) !important;
        }

        .text-gray-900,
        .text-gray-800,
        .text-text-primary {
            color: var(--retro-coffee) !important;
        }

        .text-gray-700,
        .text-gray-600,
        .text-gray-500,
        .text-text-secondary {
            color: var(--retro-muted) !important;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            letter-spacing: 0;
            text-transform: none;
            font-feature-settings: 'liga';
        }

        #sidebar h2,
        #sidebar p,
        #sidebar span:not(.material-symbols-outlined),
        #sidebar a span:not(.material-symbols-outlined) {
            color: var(--retro-cream) !important;
        }

        #sidebar a {
            color: var(--retro-cream) !important;
            border: 1px solid transparent;
        }

        #sidebar a:hover,
        #sidebar a.bg-white\/40 {
            background: rgba(255, 246, 223, 0.12) !important;
            border-color: rgba(255, 246, 223, 0.32);
            box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.18);
        }

        #sidebar .material-symbols-outlined {
            color: #ffd486 !important;
        }

        nav.glass-card {
            background: var(--retro-cream) !important;
            border: 2px solid var(--retro-coffee) !important;
        }

        .bg-gray-50,
        .bg-slate-50,
        .bg-emerald-50,
        .bg-violet-50,
        .bg-amber-50,
        .bg-blue-50,
        .bg-cyan-50 {
            background: rgba(226, 200, 145, 0.26) !important;
        }

        .rounded-full {
            border-radius: 999px;
        }
    </style>
</head>
<body class="antialiased font-sans">



