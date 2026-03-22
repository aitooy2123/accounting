<style>
  /* ROOT COLORS */

  :root {
    --primary: #6366f1;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --bg: #f1f5f9;
    --card: #ffffff;
    --card-light: rgba(255, 255, 255, .75);
    --card-dark: rgba(30, 41, 59, .7);
  }

  /* BODY */

  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    transition: .3s;
  }

  /* DARK MODE */

  body.dark-mode {
    background: #0f172a;
    color: #f1f5f9;
  }

  /* SIDEBAR */

  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 230px;
    height: 100vh;
    background: linear-gradient(180deg, #111827, #1f2937);
    color: #fff;
    overflow-y: auto;
    transition: .3s;
    z-index: 1000;
  }

  .sidebar.collapsed {
    width: 70px;
  }

  .sidebar h4 {
    padding: 18px;
    text-align: center;
    font-weight: 700;
  }

  .sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    color: #cbd5e1;
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: .25s;
  }

  .sidebar a:hover {
    background: rgba(99, 102, 241, .15);
    color: #fff;
    border-left: 3px solid var(--primary);
  }

  .sidebar a.active {
    background: var(--primary);
    color: #fff;
  }

  .sidebar.collapsed a span {
    display: none;
  }

  /* MENU HEADER */

  .menu-header {
    padding: 10px 18px;
    font-size: 11px;
    color: #9ca3af;
    text-transform: uppercase;
    margin-top: 15px;
  }

  .sidebar.collapsed .menu-header {
    display: none;
  }

  /* TOP NAVBAR */

  .top-navbar {
    margin-left: 230px;
    height: 60px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
    transition: .3s;
    position: sticky;
    top: 0;
    z-index: 999;
  }

  .sidebar.collapsed+.top-navbar {
    margin-left: 70px;
  }

  body.dark-mode .top-navbar {
    background: #1f2937;
    color: #fff;
  }

  /* NAVBAR */

  .nav-left {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  /* SIDEBAR BUTTON */

  .sidebar-toggle {
    font-size: 18px;
    cursor: pointer;
  }

  /* DARK MODE BUTTON */

  .btn-dark-toggle {
    border: none;
    background: #f3f4f6;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  body.dark-mode .btn-dark-toggle {
    background: #374151;
    color: #fff;
  }

  /* USER */

  .user-trigger {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
  }

  .avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
  }

  /* CONTENT */

  .content {
    margin-left: 230px;
    padding: 30px;
    transition: .3s;
    flex: 1;
  }

  .sidebar.collapsed~.content {
    margin-left: 70px;
  }

  /* FOOTER */

  .footer {
    margin-left: 230px;
    padding: 15px 30px;
    background: #fff;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    transition: .3s;
  }

  .sidebar.collapsed~.footer {
    margin-left: 70px;
  }

  body.dark-mode .footer {
    background: #1f2937;
    border-top: 1px solid #374151;
    color: #cbd5e1;
  }

  /* MODERN TABLE */

  .table-custom {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
  }

  .table-custom thead {
    background: #f8fafc;
  }

  .table-custom th {
    padding: 12px 15px;
    font-weight: 600;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
  }

  .table-custom td {
    padding: 12px 15px;
    border-bottom: 1px solid #f1f5f9;
  }

  .table-custom tbody tr:hover {
    background: #f9fafb;
  }

  /* DARK TABLE */

  body.dark-mode .table-custom {
    background: #1f2937;
    color: #e5e7eb;
  }

  body.dark-mode .table-custom thead {
    background: #374151;
  }

  body.dark-mode .table-custom td,
  body.dark-mode .table-custom th {
    border-color: #374151;
  }

  body.dark-mode .table-custom tbody tr:hover {
    background: #374151;
  }

  /* TABLE RESPONSIVE */

  .table-responsive {
    width: 100%;
    overflow-x: auto;
  }

  /* GLASS CARD */

  .card-glass {
    background: rgba(255, 255, 255, .7);
    backdrop-filter: blur(12px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, .3);
    box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
    padding: 25px;
    margin-bottom: 20px;
  }

  body.dark-mode .card-glass {
    background: rgba(30, 41, 59, .7);
    color: #fff;
  }

  /* GLASS FORM CARD */

  .glass-card {
    backdrop-filter: blur(14px);
    background: var(--card-light);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, .2);
  }

  body.dark-mode .glass-card {
    background: var(--card-dark);
  }

  /* BADGES */

  .badge {
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 500;
  }

  .badge-success {
    background: #d1fae5;
    color: #065f46;
  }

  .badge-danger {
    background: #fee2e2;
    color: #7f1d1d;
  }

  /* BUTTONS */

  .btn {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
  }

  .btn-success {
    background: var(--success);
    color: white;
  }

  .btn-danger {
    background: var(--danger);
    color: white;
  }

  .btn-modern {
    border-radius: 50px;
    padding: 10px 28px;
    background: linear-gradient(90deg, #10b981, #059669);
    border: none;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: all .25s ease;
    box-shadow: 0 4px 12px rgba(16, 185, 129, .35);
  }

  .btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(16, 185, 129, .45);
    background: linear-gradient(90deg, #059669, #047857);
  }

  .btn-modern:active {
    transform: scale(.97);
    box-shadow: 0 3px 10px rgba(16, 185, 129, .3);
  }

  /* MOBILE */

  @media(max-width:768px) {

    .sidebar {
      left: -230px;
    }

    .sidebar.active {
      left: 0;
    }

    .top-navbar {
      margin-left: 0;
    }

    .content {
      margin-left: 0;
      padding: 20px;
    }

    .footer {
      margin-left: 0;
    }

    .username {
      display: none;
    }

  }
</style>
<style>
.tooltip-inner {
  background-color: #111;
  color: #fff;
  font-size: 12px;
  padding: 6px 10px;
  border-radius: 6px;
}

.bs-tooltip-top .arrow::before {
  border-top-color: #111 !important;
}
</style>
