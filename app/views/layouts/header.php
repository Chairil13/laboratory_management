<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Smart Lab MS</title>
    
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
        /* Glassmorphism utilities */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-stat {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        
        /* Form input styling with better contrast */
        .form-input {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1.5px solid rgba(156, 163, 175, 0.4);
        }
        
        .form-input:hover {
            border-color: rgba(156, 163, 175, 0.6);
        }
        
        .form-input:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgb(16, 185, 129);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        /* Smooth animations */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
        }
        
        /* Material icons thin */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 200, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Gradient background */
        body {
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 50%, #fef3e2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="antialiased font-sans">
