:root {
    --bg-dark: #120b29;
    --card-dark: #1d1536;
    --sidebar-dark: #0f0821;
    --accent: #ffc107;
    --text-muted: #b5b3bc;
}
body { background-color: var(--bg-dark); color: white; font-family: 'Inter', sans-serif; }
.main-content { margin-left: 260px; padding: 40px; }
.card { background: var(--card-dark); border: none; color: white; border-radius: 12px; }
.form-control, .form-select { background: #2b214a; border: 1px solid #3c325c; color: white; }
.form-control:focus { background: #352a5a; color: white; border-color: var(--accent); }
.table { color: white; }
.table-hover tbody tr:hover { background-color: rgba(255,255,255,0.05); color: white; }