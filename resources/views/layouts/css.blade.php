<style>
  :root {
    --primary: #6366f1;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
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

  /* NAVBAR */

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

  /* NAV LEFT / RIGHT */

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

  .sidebar-toggle {
    font-size: 18px;
    cursor: pointer;
  }

  /* DARK BUTTON */

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
    color: white;
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

    /* TABLE */

    .table-custom {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
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

    /* DARK MODE */

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

    /* RESPONSIVE TABLE */

    .table-responsive {
      width: 100%;
      overflow-x: auto;
    }

    /* ACTION BUTTON */

    .table-action {
      display: flex;
      gap: 5px;
    }

    .btn-table {
      padding: 5px 10px;
      font-size: 12px;
      border-radius: 5px;
    }
  }
</style>
