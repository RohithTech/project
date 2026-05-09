<?php
// Header and scroll includes removed because the files
// do not exist in this project and were causing warnings.
?>



<!-- COMMITTEE QUICK NAVIGATION -->
<style>
  .nsb-layout-container {
    display: flex;
    flex-wrap: wrap;
    margin: 0 auto;
    gap: 30px;
    align-items: flex-start;
  }

  /* Left Sidebar */
  .statutory-tabs {
    display: flex;
    flex-direction: column;
    width: 350px;
    flex-shrink: 0;
    gap: 0;
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px); /* Limit height to viewport to allow scrolling */
    overflow-y: auto;
    padding: 15px 0;
    background-color: #f9f9fb; /* Subtle grey as in reference */
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
  }
  
  /* Scrollbar styling for sidebar */
  .statutory-tabs::-webkit-scrollbar {
    width: 6px;
  }
  .statutory-tabs::-webkit-scrollbar-track {
    background: transparent;
  }
  .statutory-tabs::-webkit-scrollbar-thumb {
    background: #e0e0e0;
    border-radius: 4px;
  }
  .statutory-tabs::-webkit-scrollbar-thumb:hover {
    background: #1B9E98;
  }

  .statutory-tab-btn {
    padding: 14px 24px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    color: #444;
    background-color: transparent;
    border: none;
    border-left: 4px solid transparent;
    border-radius: 0;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: left;
    width: 100%;
  }

  .statutory-tab-btn:hover {
    background-color: #f0f2f5;
    color: #1B9E98;
  }

  .statutory-tab-btn.active {
    background-color: #fff; /* White active item over grey sidebar */
    color: #1B9E98;
    border-left-color: #1B9E98;
    box-shadow: -1px 0 0 #fff; /* Cover the left inner shadow if any */
  }

  /* Main Content Area */
  .nsb-main-content {
    flex: 1;
    min-width: 0;
  }

  /* Close Button Inside Sidebar - Only for Mobile */
  .mobile-menu-close {
    display: none;
  }

  /* Responsive Menu Button */
  .mobile-menu-toggle {
    display: none;
    background: transparent;
    color: #fff; /* White since it will sit in the teal header */
    border: none;
    padding: 0 15px; /* Add some side padding for touch target */
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: none;
    line-height: 1;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
  }
  
  .mobile-menu-toggle:hover {
    color: #f1f1f1;
  }

  @media (max-width: 992px) {
    .nsb-layout-container {
      flex-direction: column;
      align-items: stretch; /* Allow children to take full width */
      position: relative;
    }
    .mobile-menu-toggle {
      display: block;
      align-self: flex-end; /* Push to the right */
    }
    .nsb-main-content {
      width: 100%;
      display: flex;
      justify-content: center; /* Center the table inside the main content */
    }
    .statutory-tabs {
      position: fixed;
      top: 0;
      left: -100%; /* Hidden off-screen to the left */
      width: 280px;
      height: 100%;
      max-height: 100vh;
      background: #f9f9fb;
      z-index: 10000;
      box-shadow: 2px 0 20px rgba(0,0,0,0.1);
      border: none;
      border-radius: 0;
      padding: 60px 0 20px; /* Space for close button */
      transition: left 0.3s ease;
      display: flex !important; /* Override inline styles */
      flex-direction: column;
      justify-content: flex-start;
    }
    .statutory-tabs.show-menu {
      left: 0;
    }
    .statutory-tab-btn {
      width: 100%;
      text-align: left;
      border-bottom: 1px solid #eee;
      padding: 15px 20px;
    }
    .statutory-tab-btn:hover, .statutory-tab-btn.active {
      transform: none;
    }

    /* Close Button Inside Sidebar */
    .mobile-menu-close {
      display: block;
      position: absolute;
      top: 15px;
      right: 15px;
      background: transparent;
      border: none;
      font-size: 28px;
      color: #333;
      cursor: pointer;
      line-height: 1;
    }
      border: none;
      font-size: 28px;
      color: #333;
      cursor: pointer;
      line-height: 1;
    }

    /* Dark Overlay */
    .menu-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.4);
      z-index: 9999;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
    }
    .menu-overlay.show {
      opacity: 1;
      visibility: visible;
    }
  }

  @media (max-width: 768px) {
    .statutory-tab-btn {
      font-size: 12px;
      padding: 6px 12px;
    }
    .gdlr-core-course-item {
      padding: 15px 10px 20px;
    }
    .nsb-page-title h2 {
      font-size: 16pt;
      padding: 10px 0;
    }
    .gdlr-core-course-item table {
      display: block;
      width: 100%;
      overflow-x: auto;
      font-size: 14px;
      border-radius: 8px;
      margin: 15px auto;
    }
    .gdlr-core-course-item table th .btn {
      font-size: 14pt !important;
      padding: 8px 0;
    }
    .gdlr-core-course-item table th, 
    .gdlr-core-course-item table td {
      padding: 6px 10px;
      text-align: center;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var nav = document.getElementById('committee-nav');
    if (!nav) return;

    var headings = document.querySelectorAll('.gdlr-core-course-item h4.btn');
    var tables = [];

    headings.forEach(function (h4, index) {
      var table = h4.closest('table');
      if (!table) return;

      var id = table.id || ('committee-section-' + (index + 1));
      table.id = id;
      tables.push(table);

      var text = h4.textContent.trim();
      if (!text) return;

      var btn = document.createElement('button');
      btn.className = 'statutory-tab-btn';
      btn.type = 'button';
      btn.textContent = text;
      btn.dataset.targetId = id;

      btn.addEventListener('click', function () {
        tables.forEach(function (tbl) {
          tbl.style.display = (tbl.id === id) ? 'table' : 'none';
        });

        var allBtns = nav.querySelectorAll('.statutory-tab-btn');
        allBtns.forEach(function (b) {
          b.classList.toggle('active', b === btn);
        });

        // Hide menu after selection on mobile
        if (window.innerWidth <= 992) {
           var overlay = document.getElementById('menu-overlay');
           nav.classList.remove('show-menu');
           if (overlay) overlay.classList.remove('show');
           document.body.style.overflow = '';
        }

        var container = document.querySelector('.gdlr-core-course-item');
        if (container) {
          container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });

      nav.appendChild(btn);
    });

    if (tables.length) {
      tables.forEach(function (tbl, idx) {
        tbl.style.display = idx === 0 ? 'table' : 'none';
      });

      var firstBtn = nav.querySelector('.statutory-tab-btn');
      if (firstBtn) {
        firstBtn.classList.add('active');
      }
    }

    // Mobile Toggle Logic
    var toggleBtn = document.getElementById('mobile-menu-btn');
    var overlay = document.getElementById('menu-overlay');
    var closeBtn = document.getElementById('mobile-menu-close');

    function toggleMenu(show) {
      if (show) {
        nav.classList.add('show-menu');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden'; // prevent background scrolling
      } else {
        nav.classList.remove('show-menu');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
      }
    }

    if(toggleBtn && nav && overlay) {
      toggleBtn.addEventListener('click', function() {
        toggleMenu(!nav.classList.contains('show-menu'));
      });
      
      overlay.addEventListener('click', function() {
        toggleMenu(false);
      });

      if(closeBtn) {
        closeBtn.addEventListener('click', function() {
           toggleMenu(false);
        });
      }
    }
  });
</script>

<style>
  .gdlr-core-course-item {
    background: #ffffff; /* Main white container */
    border-radius: 12px;
    padding: 24px 24px 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); /* Softer overall shadow */
    backdrop-filter: blur(4px);
  }

  .gdlr-core-course-item h2.btn,
  .gdlr-core-course-item h4.btn {
    display: block;
    width: 100%;
    margin: 0;
    padding: 12px 0;
    border-radius: 0;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    font-weight: bold;
    border: 0;
    box-shadow: none;
    font-family: 'Times New Roman', Times, serif;
    box-sizing: border-box;
    text-align: center;
  }

  .nsb-page-title {
    width: 100%;
    margin: 0;
    text-align: center;
  }

  .nsb-page-title h2 {
    margin: 0;
    padding: 15px 0;
    background-color: #1B9E98;
    color: #fff;
    font-size: 20pt;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    width: 100%;
    display: flex; /* Makes alignment of button easier inside */
    align-items: center;
    justify-content: center; /* Center text */
    position: relative; /* For the absolute button */
    border-radius: 12px;
  }

  .gdlr-core-course-item table {
    width: 100%;
    max-width: 900px;
    margin: 24px auto 32px;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 18px;
    font-family: 'Times New Roman', Times, serif;
    min-width: 0 !important;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .gdlr-core-course-item table tbody {
    color: #243b53 !important;
  }

  .gdlr-core-course-item table th {
    padding: 14px 18px;
  }

  .gdlr-core-course-item table td {
    padding: 8px 16px;
    border: none !important;
  }

  .gdlr-core-course-item table tbody tr:nth-child(even) td {
    background-color: #f7f9fc; /* Very subtle off-white/blueish tint for tables */
  }

  .gdlr-core-course-item table tbody tr:nth-child(odd) td {
    background-color: #ffffff;
  }

  .gdlr-core-course-item table tbody tr:hover td {
    background-color: rgba(27, 158, 152, 0.05); /* Softer hover color */
  }

  .back-to-top-btn {
    position: fixed;
    right: 22px;
    bottom: 22px;
    padding: 10px 18px;
    border-radius: 999px;
    background: #1B9E98;
    color: #fff;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.22);
    display: none;
    z-index: 999;
    transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, opacity 0.2s ease;
    opacity: 0.9;
  }

  .back-to-top-btn:hover {
    background: #14726e;
    transform: translateY(-2px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.26);
    opacity: 1;
  }
</style>

<script>
  (function () {
    const btnId = 'backToTopBtn';

    function onScroll() {
      var btn = document.getElementById(btnId);
      if (!btn) return;
      if (window.scrollY > 300) {
        btn.style.display = 'inline-flex';
      } else {
        btn.style.display = 'none';
      }
    }

    window.addEventListener('scroll', onScroll);

    window.backToTopSmooth = function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    };
  })();
</script>

<div class="kingster-page-wrapper" id="kingster-page-wrapper"
  style="background:url('../images/pattern1.png'); background-repeat:repeat;">
  <div class="kingster-content-container kingster-container">
    <div class=" kingster-sidebar-wrap clearfix kingster-line-height-0 kingster-sidebar-style-right">
      <div class=" kingster-sidebar-center kingster-column-60 kingster-line-height">
        <div class="gdlr-core-page-builder-body">
          <div class="gdlr-core-pbf-wrapper ">
            <div class="gdlr-core-pbf-wrapper-content gdlr-core-js ">
              <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">

                <div class="gdlr-core-pbf-element">
                  <div class="nsb-page-title">
                    <h2>
                      NON-STATUTORY BODIES
                      <button id="mobile-menu-btn" class="mobile-menu-toggle" aria-label="Menu">&#9776;</button>
                    </h2>
                  </div>
                  <div
                    class="gdlr-core-course-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-course-style-list-info">
                    
                    <div id="menu-overlay" class="menu-overlay"></div>
                    
                    <div class="nsb-layout-container">
                      <div id="committee-nav" class="statutory-tabs">
                          <button id="mobile-menu-close" class="mobile-menu-close">&times;</button>
                      </div>
                      <div class="nsb-main-content">

                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">STAFF COUNCIL
                              </h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Rev. Dr. Anbarasu MSJ </td>
                            <td>Principal </td>
                            <td>Chairperson </td>
                          </tr>
                          <tr>
                            <td>2. Mr. Deva Prince SA </td>
                            <td>Dean-Academic (Science) </td>
                            <td>Convener </td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Basil Xavier SSJ </td>
                            <td>Rector </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Antonysamy A SJ </td>
                            <td>Secretary </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>5. Dr. Sundararaj A </td>
                            <td>Deputy Principal </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>6. Rev. Br. Joseph M SJ </td>
                            <td>Treasurer </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>7. Dr. Rayappan S </td>
                            <td>Vice Principal (Shift-I) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>8. Rev. Dr.Jeyabaskaran SSJ </td>
                            <td>Vice Principal (Shift-I) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>9. Rev. Fr. Innaci John V SJ </td>
                            <td>Vice Principal (Shift-II) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>10. Dr. Kadher Farook R </td>
                            <td>Vice Principal (Shift-II) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>11. Ms. Virgin Arockia Mary M </td>
                            <td>Vice Principal (Shift-II) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>12. Dr. Arul Prasad S </td>
                            <td>Dean-Academic (Arts) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>13. Dr. Nivetha Martin </td>
                            <td>Dean-Research </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>14. Dr. Ganesh S </td>
                            <td>Dean-Students </td>
                            <td>Member </td>
                          </tr>

                          <tr>
                            <td>15. Dr. Jenifa D </td>
                            <td>Dean -Women Students </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>16. Rev. Dr. SebastianMahimairaj A MC </td>
                            <td>Controller of Examinations </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>17. Dr. Gilbert Rani M </td>
                            <td>Coordinator-IQAC </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>18. Dr. Gurusamy G </td>
                            <td>HoD, Tamil </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>19. Ms. SahayaJosephine Mary A </td>
                            <td>HoD, English </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>20. Dr. Kala T </td>
                            <td>HoD, History </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>21. Dr. Antony Singh Dhas D </td>
                            <td>HoD, Economics </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>22. Dr. Arulappan M </td>
                            <td>HoD, Philosophy </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>23. Mr. Robert Dhiliban J </td>
                            <td>HoD, Mathematics </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>24. Dr. Shanmugaraju A </td>
                            <td>HoD, Physics </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>25. Dr. Savitha Devi N </td>
                            <td>HoD, Chemistry </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>26. Dr. Pandeeswari M </td>
                            <td>HoD, RDS </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>27. Dr. Michaelraj A </td>
                            <td>HoD, Commerce </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>28. Dr. Vanitha J </td>
                            <td> Director, Physical Education </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>29. Ms. Krithika E </td>
                            <td>HoD, FST </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>30. Dr. Manimegala S </td>
                            <td>HoD, Tamil Literature </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>31. Dr. Raja A </td>
                            <td>HoD, English Literature </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>32. Dr. Stephen Jeyaraj A </td>
                            <td>HoD, Commerce (Gen) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>33. Dr. Ramya K </td>
                            <td>HoD, Commerce (CA) </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>34. Dr. Arun Prasad S </td>
                            <td> HoD, Business Administration </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>35. Mr. Albert Irudayaraj J </td>
                            <td> HoD, Info. Technology </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>36. Dr. Muthukumar A </td>
                            <td>HoD, Physical Education </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>37. Mr. Manoj Prabakaran T </td>
                            <td>HoD, Computer Science & Computer Applications </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>38. Rev. Dr.Sekhar B. Vincent SJ </td>
                            <td>HoD, Human Excellence </td>
                            <td>Member </td>
                          </tr>
                          <tr>
                            <td>39. Ms. Grasi S </td>
                            <td>Office Superintendent </td>
                            <td>Member </td>
                          </tr>


                          </tr>
                        </tbody>
                      </table>






                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">STUDENTS
                                COUNCIL</h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Mr. Ranjith Kumar N</td>
                            <td>Fine Arts Secretary (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Aathithya A</td>
                            <td>Fine Arts Secretary (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>3. Mr.Mohammed Salahudeen</td>
                            <td>Sports Secretary (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Alan James V</td>
                            <td>Sports Secretary (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Sivasri Aishwarya P</td>
                            <td>Girls' Representative (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>6. Ms.Jeya PrapaJ</td>
                            <td>Girls' Representative (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Mathan R</td>
                            <td>Day Scholar Representative (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>8. Mr.Jeeva T</td>
                            <td>Day Scholar Representative (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Harini P</td>
                            <td>III Year UG Representative (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Surya R</td>
                            <td>III Year UG Representative (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Madhumalar G</td>
                            <td>II Year UG Representative (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>12. Mr. Madhavan K</td>
                            <td>II Year UG Representative (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>13. Mr. Mithun V</td>
                            <td>PG Representative</td>
                          </tr>
                          <tr>
                            <td>14. Mr. Saran T</td>
                            <td>Association Secretary, Tamil (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>15. Mr. Deva Vignesh T</td>
                            <td>Association Secretary, English (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>16. Mr. Nithishkumar P</td>
                            <td>Association Secretary, FC (Shift-I)</td>
                          </tr>
                          <tr>
                            <td>17. Mr. Tinu Jose A</td>
                            <td>Association Secretary, FC (Shift-II)</td>
                          </tr>
                          <tr>
                            <td>18. Mr. Palpandi S</td>
                            <td>Department Secretary, History</td>
                          </tr>
                          <tr>
                            <td>19. Mr. Jegan S</td>
                            <td>Department Secretary, Economics</td>
                          </tr>
                          <tr>
                            <td>20. Mr. Sahaya Antony Salet</td>
                            <td>Department Secretary, Philosophy</td>
                          </tr>
                          <tr>
                            <td>21. Mr. Maria Sountharaj</td>
                            <td>Department Secretary, Mathematics</td>
                          </tr>
                          <tr>
                            <td>22. Mr. Kathir Mayan E</td>
                            <td>Department Secretary, Physics</td>
                          </tr>
                          <tr>
                            <td>23. Mr. Kaleeswaran A</td>
                            <td>Department Secretary, Chemistry</td>
                          </tr>
                          <tr>
                            <td>24. Ms. Kodiyarasi J</td>
                            <td>Department Secretary, RDS</td>
                          </tr>
                          <tr>
                            <td>25. Mr. Adithya C</td>
                            <td>Department Secretary, FST</td>
                          </tr>
                          <tr>
                            <td>26. Mr. Nitheeshkumar M</td>
                            <td>Department Secretary, CS&CA</td>
                          </tr>
                          <tr>
                            <td>27. Ms. Yuvasri P</td>
                            <td>Department Secretary, CS&CA</td>
                          </tr>
                          <tr>
                            <td>28. Mr. Poonkodi A</td>
                            <td>Department Secretary, Tamil Literature</td>
                          </tr>
                          <tr>
                            <td>29. Mr. Edwin RahulX</td>
                            <td>Department Secretary, English Literature</td>
                          </tr>
                          <tr>
                            <td>30. Mr. Athithya C</td>
                            <td>DepartmentSecretary,Commerce with CA</td>
                          </tr>
                          <tr>
                            <td>31. Mr. Manikandan M</td>
                            <td>DepartmentSecretary,Commerce(General)</td>
                          </tr>
                          <tr>
                            <td>32. Mr. Mariya George V</td>
                            <td>Department Secretary, Bus. Admin</td>
                          </tr>
                          <tr>
                            <td>33. Ms. Priyanga S</td>
                            <td>Department Secretary, Info. Technology</td>
                          </tr>
                          <tr>
                            <td>34. Ms. Valarmathy L</td>
                            <td>DepartmentSecretary, Physical Education</td>
                          </tr>


                          </tr>
                        </tbody>
                      </table>




                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">PLANNING AND
                                EVALUATION COMMITTEE</h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Deva Prince SA</td>
                            <td>Dean-Academic (Science)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Basil Xavier S SJ</td>
                            <td>Rector</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Br. Joseph M SJ</td>
                            <td>Treasurer</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr.SundararajA</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Nivetha Martin</td>
                            <td>Dean-Research</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Dr. Jenifa D</td>
                            <td>Dean-Women Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Rev. Dr. Sebastian Mahimairaj A MC</td>
                            <td>Controller of Examinations</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>17. Dr. Gilbert Rani M</td>
                            <td>Coordinator-IQAC</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>18. Ms. Sahaya Josephine Mary A</td>
                            <td>HoD's Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>19. Ms. JegadeeswariS</td>
                            <td>Staff Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>20. Rev. Fr. Joseph ASJ</td>
                            <td>Counsellor</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>21. Dr. Michaelraj A</td>
                            <td>Coordinator-Mentor Care</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>22. Ms. Grasi S</td>
                            <td>Office Superintendent</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>23. Mr. Thomas Acqvinas</td>
                            <td>PA to Fr. Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>24. Members of Students Council</td>
                            <td></td>
                            <td>Members</td>
                          </tr>



                          </tr>
                        </tbody>
                      </table>
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">INTERNAL
                                QUALITY ASSURANCE CELL (IQAC)</h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Gilbert Rani M</td>
                            <td>Coordinator</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr.Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Innaci John V SJ</td>
                            <td>Management Rep.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr.Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Deva Prince SA</td>
                            <td>Dean-Academic (Science)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Rev.Dr.Sebastian MahimairajAMC</td>
                            <td>Controller of Examinations</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Nivetha Martin</td>
                            <td>Dean-Research</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Jenifa D</td>
                            <td>Dean-Women Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Ms. Sahaya Josephine Mary A</td>
                            <td>HoD, English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Antony Singh Dhas D</td>
                            <td>HoD, Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Dr. Valanarasu S</td>
                            <td>Asso. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Dr. Nirmal Rajkumar A</td>
                            <td>Asso. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>17. Dr. Arulappan M</td>
                            <td>HoD, Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>18. Rev. Dr. Anto Nelson A</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>19. Mr. Anthony Raj P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>20. Dr. Mabel Joshaline C</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>21. Dr.Sophia J</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>22. Dr. Adaikalaraj G</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>23. Dr. Nallathambi P</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>24. Dr. Amalraj M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>25. Dr. Sankaranarayanan K</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>26. Mr. Ratheesh A</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>27. Ms. Primrose K</td>
                            <td>Asst. Prof., English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>28. Dr. Parthipan P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>29. Dr. Sonia M</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>30. Mr. Keba Immanuvel J</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>31. Ms. Glory Gursheth A</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>32. Ms. Grasi S</td>
                            <td>Office Superintendent</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>33. Ms. Sharmila Raji K</td>
                            <td>Student Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>34. Mr. Kathirmayan E</td>
                            <td>Student Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>35. Ms. Saranya</td>
                            <td>Alumni Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>36. Mr. Sanjay</td>
                            <td>Industrial Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>37. Mr. Chellapandy R</td>
                            <td>Local Member</td>
                            <td>Member</td>
                          </tr>


                          </tr>
                        </tbody>
                      </table>
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">CURRICULUM
                                DEVELOPMENT CELL (CDC)</h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Deva Prince SA</td>
                            <td>Dean-Academic (Science)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Sebastian Mahimairaj A MC</td>
                            <td>Controller of Examinations</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Gilbert Rani M</td>
                            <td>Coordinator, IQAC</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr.Shanmugaraju A</td>
                            <td>HoD, Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Antony Singh Dhas D</td>
                            <td>HoD, Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Martin S</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Rev. Dr. Elphinston KishoreT</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Mabel Joshaline C</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Rajeswari S</td>
                            <td>Asst. Prof., Com with CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Mr. Stephen Jeyaraj A</td>
                            <td>HoD, Commerce (General)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Arun Prasad S</td>
                            <td>HoD, Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Dr. Muthu Kumar A</td>
                            <td>HoD, Phy. Edu.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Mr. Albert lrudayaraj J</td>
                            <td>HoD, IT</td>
                            <td>Member</td>
                          </tr>


                          </tr>
                        </tbody>
                      </table>
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ACADEMIC AUDIT
                                COMMITTEE</h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Gilbert Rani M</td>
                            <td>Coordinator, IQAC</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Deva Prince SA</td>
                            <td>Dean-Academic (Science)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr.Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Shanmugaraju A</td>
                            <td>HoD, Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. AbiramiS</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Ramkumar G</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Ramya K</td>
                            <td>HoD, Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Revathi P</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>


                          </tr>
                        </tbody>
                      </table>
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">FUND FOR
                                IMPROVEMENT OF SCIENCE AND TECHNOLOGY : FIST-DST IMPLEMENTATION COMMITTEE</h4>
                            </th>
                          </tr>


                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Nivetha Martin</td>
                            <td>Dean-Research</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Shanmugaraju A</td>
                            <td>Asso. Prof. & HoD Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Valanarasu S</td>
                            <td>Asso. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Savitha Devi N</td>
                            <td>HoD, Chemistry</td>
                            <td>Member</td>
                          </tr>


                          </tr>
                        </tbody>
                      </table>

                      <!-- New ADMISSIONS COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ADMISSIONS
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Admissions Officer</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">AIDED</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Ganesh S</td>
                            <td>Dean - Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. James A</td>
                            <td>Asst. Prof., RDS, Assistant Coordinator - Dalit Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Kala T</td>
                            <td>HoD, History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Nirmal Rajkumar V</td>
                            <td>Asso. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Sophia J</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Amalraj M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Primrose K</td>
                            <td>Asst. Prof., English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">SELF FINANCED</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Juliet Shanthi I</td>
                            <td>Asst. Prof., Computer Science, Asst. Coordinator - Dalit Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Raja A</td>
                            <td>HoD, English Literature</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Xavier P</td>
                            <td>Asst. Prof., English Literature</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Makeswari P</td>
                            <td>Asst. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Kathiresan K</td>
                            <td>Asst. Prof., Phy. Education</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Krithika E</td>
                            <td>HoD, FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Ms. Akshaya K</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- New MIIC TABLE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">MHRD
                                INNOVATION AND IPR CELL (MIIC)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>President</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Amalraj M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Martin J</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Inigo Valan I</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Parthipan P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Geno Kadwin J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Sonia M</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Muthuperumal P V</td>
                            <td>Asst. Prof., Bus. Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Sowmiya Devi K</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Lige K V</td>
                            <td>Asst. Prof., Commerce (Gen)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Sarulatha R</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Vinoth Kumar R A</td>
                            <td>Asst. Prof., Comp. Science</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Ms. Susma T</td>
                            <td>Asst. Prof., IT</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- RESEARCH COUNCIL & ETHICS COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">RESEARCH
                                COUNCIL & ETHICS COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Nivetha Martin</td>
                            <td>Dean-Research</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Shanmugaraju A</td>
                            <td>Asso. Prof. & HoD Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Valanarasu S</td>
                            <td>Asso. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Anushya M</td>
                            <td>Arts Scholar (Economics)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Fr. Mark Stephen J</td>
                            <td>Arts Scholar (Philosophy)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Aswin Amirtha Raj S</td>
                            <td>Science Scholar (Physics)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- RESEARCH & DEVELOPMENT CELL -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">RESEARCH &
                                DEVELOPMENT CELL</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Nivetha Martin</td>
                            <td>Dean-Research</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Nallathambi P</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Elphinston Kishore T</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Amalraj M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Sankaranarayanan K</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Justin David C</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Inigo Valan I</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Rajeswari S</td>
                            <td>Asst. Prof., Commerce</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Revathi P</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Vinoth Kumar R</td>
                            <td>Asst. Prof., CS&CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Muthu Perumal P V</td>
                            <td>Asst. Prof., Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Xavier P</td>
                            <td>Asst. Prof., English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Malar Vizhi D</td>
                            <td>Asst. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- BRITTO PUBLISHING HOUSE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">BRITTO
                                PUBLISHING HOUSE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Nirmal Rajkumar V</td>
                            <td>Asso. Prof., Economics</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Michael Venish V</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Kalidoss B</td>
                            <td>Asst. Prof., English Literature</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- LIBRARY COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">LIBRARY
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Bosco J</td>
                            <td>Librarian</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Antony Singh Dhas D</td>
                            <td>HoD, Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Arulappan M</td>
                            <td>HoD, Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Malar Kannan S P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Manimegala S</td>
                            <td>Asst. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Karuppathevan O</td>
                            <td>Library Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- PURCHASE AND PHYSICAL INVENTORY COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">PURCHASE AND
                                PHYSICAL INVENTORY COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Br. Joseph M SJ</td>
                            <td>Treasurer</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Sajan Joseph M</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Ms. Grasi S</td>
                            <td>Office Superintendent</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Thomas Acqvinas R</td>
                            <td>Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- INFRASTRUCTURE COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">INFRASTRUCTURE
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Anthony Raj P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Co-convener</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Br. Joseph M SJ</td>
                            <td>Treasurer</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Rev. Fr. Antony Selvam SJ</td>
                            <td>Minister, Arrupe Illam</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Jeyaraj I</td>
                            <td>Asso. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Valanarasu S</td>
                            <td>Asso. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Mr. Bosco J</td>
                            <td>Librarian</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Edward Xavier S</td>
                            <td>Store Keeper</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- ICT AND ENTERPRISE RESOURCE PLANNING COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ICT AND
                                ENTERPRISE RESOURCE PLANNING COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Advisor</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Charles Ilayaraja S</td>
                            <td>Asst. Prof., CS&CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Vinoth Kumar R A</td>
                            <td>Asst. Prof., CS&CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Albert Irudayaraj J</td>
                            <td>HoD, Information Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Arockiam R</td>
                            <td>System Administrator</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Saravanakunar A</td>
                            <td>Web Administrator</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Mr. Suresh A</td>
                            <td>Electrician</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Bastin Vinoth S</td>
                            <td>Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- SWAYAM/MOOC COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">SWAYAM/MOOC
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Advisor</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Amalraj M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Jeyaraj I</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Mabel Joshaline C</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Rev. Dr. Elphinston Kishore T</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Sophia J</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Nanda Kumar E</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Geeso Radwan J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Ramya K</td>
                            <td>HoD, Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Ramya K</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Mr. Siva Kumar A</td>
                            <td>Asst. Prof., Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Ms. Kalaiselvi A</td>
                            <td>Asst. Prof., CS&CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Rejina Devi K</td>
                            <td>Asst. Prof., Phy. Education</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Ms. Susma T</td>
                            <td>Asst. Prof., Info. Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Ms. Kaviya P</td>
                            <td>Asst. Prof., Commerce (Gen)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- EXAMINATION AND AWARDS COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">EXAMINATION
                                AND AWARDS COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Sebastian Mahimairaj A MC</td>
                            <td>Controller of Examinations</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Mr. Deva Prince S A</td>
                            <td>Dean-Academic (Science)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Nivetha Martin</td>
                            <td>Dean-Research</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Jenifa D</td>
                            <td>Dean-Women Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Dr. Gilbert Rani M</td>
                            <td>Coordinator-IQAC</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Dr. Gurusamy G</td>
                            <td>HoD, Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>17. Ms. Sahaya Josephine Mary A</td>
                            <td>HoD, English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>18. Dr. Kalai T</td>
                            <td>HoD, History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>19. Dr. Antony Singh Dhas D</td>
                            <td>HoD, Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>20. Dr. Arulappan M</td>
                            <td>HoD, Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>21. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>22. Dr. Shanmugaraju A</td>
                            <td>HoD, Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>23. Dr. Savitha Devi N</td>
                            <td>HoD, Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>24. Dr. Pandeeswari M</td>
                            <td>HoD, RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>25. Dr. Michaelraj A</td>
                            <td>HoD, Commerce</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>26. Dr. Venisha J</td>
                            <td>Director, Phy. Edu.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>27. Mr. Manoj Prabakaran T</td>
                            <td>HoD, CS & CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>28. Ms. Krithika E</td>
                            <td>HoD, FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>29. Dr. Manimegala S</td>
                            <td>HoD, Tamil Literature</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>30. Dr. Raja A</td>
                            <td>HoD, English Literature</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>31. Mr. Stephen Jeyaraj A</td>
                            <td>HoD, Commerce (General)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>32. Dr. Ramya K</td>
                            <td>HoD, Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>33. Dr. Arun Prasad S</td>
                            <td>HoD, Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>34. Mr. Albert Irudayaraj J</td>
                            <td>HoD, Information Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>35. Dr. Muthukumar A</td>
                            <td>HoD, Physical Education</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>36. Rev. Dr. Sebastian T</td>
                            <td>HoD, Philosophy Elect</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>37. Ms. Grasi S</td>
                            <td>Office Superintendent</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- EXAMINATIONS MONITORING COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">EXAMINATIONS
                                MONITORING COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Sebastian Mahimairaj A MC</td>
                            <td>Controller of Examinations</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Respective HoD</td>
                            <td></td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Respective Invigilator</td>
                            <td></td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- DISCIPLINARY ACTION COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">DISCIPLINARY
                                ACTION COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">Shift‑I</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Ganesh S</td>
                            <td>Dean‑Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Jenifa D</td>
                            <td>Dean‑Women Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Shanmugaraju A</td>
                            <td>HoD, Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Kala T</td>
                            <td>HoD, History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Sankar P</td>
                            <td>PTA Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">Shift‑II</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Ramya K</td>
                            <td>HoD, Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Rajeswari S</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Kadanadasami P</td>
                            <td>PTA Representative</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- DISCIPLINE COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">DISCIPLINE
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">Shift-I</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Martin S</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Arockia Maria Michael Raja A</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Rev. Fr. Jayaseelan S SJ</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Michael Venish V</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Vanitha J</td>
                            <td>Director, Phy. Education</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Sonia M</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Sebastian S</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Revathi P</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Vinoth Kumar R A</td>
                            <td>Asst. Prof., CS&CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">Shift-II</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Johnson Stephen I</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Muthuraja C</td>
                            <td>Asst. Prof., Phy. Education</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Benjamin Prabhar I</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Muthulakshmi A</td>
                            <td>Asst. Prof., Tamil Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Sarulatha R</td>
                            <td>Asst. Prof., Info. Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Susma T</td>
                            <td>Asst. Prof., Info. Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Rejina Devi K</td>
                            <td>Asst. Prof., Phy. Education</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>


                      <!-- ANTI-RAGGING SQUAD -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ANTI-RAGGING
                                SQUAD</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Abirami S</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Michael Naveen Kumar S</td>
                            <td>Asst. Prof., Commerce</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- ATTENDANCE MONITORING COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ATTENDANCE
                                MONITORING COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">AIDED</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Nirmal Vinod Kumar S</td>
                            <td>Office Assistant</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-weight:bold;text-align:center;color:black;">SELF FINANCED</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Gnanaguru R</td>
                            <td>Office Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- STAFF GRIEVANCE REDRESSAL PANEL -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">STAFF
                                GRIEVANCE REDRESSAL PANEL</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Fr. Santhaham SJ</td>
                            <td>Advocate</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Jeyaraj I</td>
                            <td>Asso. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rajeswari S</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Pandeeswari M</td>
                            <td>President, MUTA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Ms. Kiruba M R</td>
                            <td>Secretary, TANTSAC</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- STUDENTS' GRIEVANCE AND APPEAL COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">STUDENTS'
                                GRIEVANCE AND APPEAL COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Dr. Jeyabaskaran S SJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- GIRL STUDENTS' GRIEVANCE COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">GIRL STUDENTS'
                                GRIEVANCE COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Jenifa D</td>
                            <td>Dean-Women Students</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Ms. Sahaya Josephine Mary A</td>
                            <td>HoD, English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rajeswari S</td>
                            <td>Asst. Prof., Commerce</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- GIRL STUDENTS' WELFARE COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">GIRL STUDENTS'
                                WELFARE COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Jenifa D</td>
                            <td>Dean-Women Students</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Sr. Christal Jega J</td>
                            <td>Women's Hostel Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. S. Arockia Mary</td>
                            <td>Asst. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Sowmiya Devi K</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Akshaya K</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Ms. Susma T</td>
                            <td>Asst. Prof., IT</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- WOMEN STUDIES CENTRE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">WOMEN STUDIES
                                CENTRE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Arockia Sarvia S</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Lige K V</td>
                            <td>Asst. Prof., Commerce (Gen)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- MAGAZINE COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">MAGAZINE
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Kanniyan G</td>
                            <td>Asst. Prof., English</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Keba Immanuel J</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Co-convener</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Johnson Stephen I</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rajan P</td>
                            <td>Asst. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Deva Vignesh T</td>
                            <td>Student Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Edwin Ragul X</td>
                            <td>Student Representative</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- FINE ARTS COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">FINE ARTS
                                COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Raj C S A</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Ratheesh A</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Sajan Joseph M</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Annie Jenifer N</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Ranjith Kumar N</td>
                            <td>Fine Arts Representative (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Aathithyaa A</td>
                            <td>Fine Arts Representative (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- SCHOLARSHIP AND ENDOWMENT COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">SCHOLARSHIP
                                AND ENDOWMENT COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>JES Coordinator</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Joseph M</td>
                            <td>Treasurer</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Sundararaj J</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Gnanasamy D</td>
                            <td>Office Superintendent</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Kiruba M R</td>
                            <td>Lab Assistant</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Gnanaguru R</td>
                            <td>Junior Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- CAREER GUIDANCE AND PLACEMENT CELL -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">CAREER
                                GUIDANCE AND PLACEMENT CELL</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Sankaranarayanan K</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Martin J</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Nandakumar E</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Geno Kadwin J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Sophia J</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. John Jeevagan A</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Malarkannan S P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Mr. Charles Ilayaraja S</td>
                            <td>Asst. Prof., CS &amp; CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Ms. Keerthana J</td>
                            <td>Asst. Prof., CS &amp; CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Kalaiselvi A</td>
                            <td>Asst. Prof., CS &amp; CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Revathi P</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Arockiam S</td>
                            <td>Asst. Prof., Tamil Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Ms. Glory Gursheth A J</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Mr. Navaneetha Krishnan S R</td>
                            <td>Asst. Prof., Commerce with CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Ms. Kavya P</td>
                            <td>Asst. Prof., Commerce (Gen)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>17. Mr. Ruban Sathish A</td>
                            <td>Asst. Prof., Info. Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>18. Dr. Muthu Perumal P V</td>
                            <td>Asst. Prof., Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>19. Dr. Muthuraja C</td>
                            <td>Asst. Prof., Phy. Education</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- PARENTS - TEACHERS ASSOCIATION (PTA) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">PARENTS -
                                TEACHERS ASSOCIATION (PTA)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Basil Xavier SSJ</td>
                            <td>Rector</td>
                            <td>Patron</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Patron</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Virgin Arockia Mary M</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Ganesh S</td>
                            <td>Dean-Students</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Mr. Nallakurumban M</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Jegatheeswaran S</td>
                            <td>Parent Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Ms. Dhanalakshmi M</td>
                            <td>Parent Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Ms. Amala Jeeva</td>
                            <td>Parent Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Ms. Jeyapandiammal R</td>
                            <td>Parent Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Mr. Jeyaraman A</td>
                            <td>Local Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>17. Mr. Muthupandi C</td>
                            <td>Local Representative</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- SPORTS & GAMES COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">SPORTS &amp;
                                GAMES COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Coordinator</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Vanitha J</td>
                            <td>Director of Phy. Education</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Antony Singh Dhas D</td>
                            <td>HoD, Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Robert Dhiliban J</td>
                            <td>HoD, Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Malarkannan S P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Muthukumar A</td>
                            <td>HoD, Physical Education</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Kathiresan K</td>
                            <td>Asst. Prof., Phy. Edu.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Manoj Prabaharan T</td>
                            <td>HoD, CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Stephen Johnson I</td>
                            <td>Asst. Prof., Eng. Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Mr. Saravanakumar A</td>
                            <td>Web Admin</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Mr. Karupathevan O</td>
                            <td>Marker</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Mr. Poyyamozhi P</td>
                            <td>Library Assistant</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Mr. Mohammed Salahudeen</td>
                            <td>Sports Representative (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>16. Mr. Alan James V</td>
                            <td>Sports Representative (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- CAMPUS MINISTRY -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">CAMPUS
                                MINISTRY</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Fr. Antony Selvam M SJ</td>
                            <td>Minister, Arrupe Illam</td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Sr. Christal Jega J</td>
                            <td>Director-Women's Hostel</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Kadher Farook R</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Raj C S A</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Nanda Kumar E</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Rev. Dr. John Selvaraj M</td>
                            <td>Asst. Prof., Philosophy</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Geno Kadwin J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Ms. Juliet Shanthi I</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Johnson Stephen I</td>
                            <td>Asst. Prof., English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Muthuraja C</td>
                            <td>Asst. Prof., Physical Edu.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Ms. Sowmiya Devi K</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Uma Maheswari M</td>
                            <td>Asst. Prof., Tamil Literature</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Rejina Devi K</td>
                            <td>Asst. Prof., Physical Edu.</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- HOSTEL COMMITTEE (MEN) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">HOSTEL
                                COMMITTEE (MEN)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Hostel Director</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Fr. Antony Selvam M SJ</td>
                            <td>Deputy Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Savarimuthu S P SJ</td>
                            <td>Student Counsellor</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Joseph A SJ</td>
                            <td>Student Counsellor</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Ayyanar M</td>
                            <td>Assistant Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Saleth Prabakar U</td>
                            <td>Assistant Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Bosco J</td>
                            <td>Assistant Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Mr. Antony Xavier S</td>
                            <td>Assistant Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Micheal Naveen Kumar S</td>
                            <td>Assistant Director</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- HOSTEL COMMITTEE (WOMEN) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">HOSTEL
                                COMMITTEE (WOMEN)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Hostel Director</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Sr. Christal Jega J</td>
                            <td>Women's Hostel Director</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Rev. Fr. Savarimuthu S P SJ</td>
                            <td>Student Counsellor</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Joseph A SJ</td>
                            <td>Student Counsellor</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Punitha Arockiasamy</td>
                            <td>Student Counsellor</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- PUBLIC RELATIONS COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">PUBLIC
                                RELATIONS COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Nirmal Rajkumar V</td>
                            <td>PRO</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. I. Benjamin Prabahar</td>
                            <td>Asst. Prof., Commerce</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Muniyandi K</td>
                            <td>Field Assistant</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Kannan M</td>
                            <td>Live-Stock Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- AAC ALUMNI ASSOCIATION (AACAA) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">AAC ALUMNI
                                ASSOCIATION (AACAA)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Basil Xavier SSJ</td>
                            <td></td>
                            <td>Patron</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Antonysamy A SJ</td>
                            <td></td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Anbarasu M SJ</td>
                            <td></td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Madhusudhanan Rayar R M</td>
                            <td></td>
                            <td>President</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Kadher Farook R</td>
                            <td></td>
                            <td>Vice President</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Rajagopal N</td>
                            <td></td>
                            <td>Vice President</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Robert Dhiliban J</td>
                            <td></td>
                            <td>Secretary</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Soundarrajan C</td>
                            <td></td>
                            <td>Joint Secretary</td>
                          </tr>
                          <tr>
                            <td>9. Mr. Pommayan S</td>
                            <td></td>
                            <td>Joint Secretary</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Michael Raj A</td>
                            <td></td>
                            <td>Treasurer</td>
                          </tr>
                          <tr>
                            <td>11. Dr. Jeyaraj I</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>12. Dr. Martin S</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>13. Dr. Abirami S</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>14. Dr. Sophia J</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>15. Mr. Chandran V</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>16. Mr. Kannan M</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>17. Mr. Sanmuganathan S</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>18. Mr. Pandeeswaran M</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>19. Ms. Ahila Devi M</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>20. Ms. Josili V</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                          <tr>
                            <td>21. Mr. Sridhar</td>
                            <td></td>
                            <td>EC Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- EMPOWERMENT COMMITTEE FOR SC/ST -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">EMPOWERMENT
                                COMMITTEE FOR SC/ST</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Jeyabaskaran SSJ</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Rayappan S</td>
                            <td>Vice Principal (Shift-I)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Arul Prasad S</td>
                            <td>Dean-Academic (Arts)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Joseph Charlie Arockia Doss A</td>
                            <td>Asso. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Juliet Shanthi I</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- MEDIA CENTRE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">MEDIA CENTRE
                              </h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Bosco J</td>
                            <td>Librarian</td>
                            <td>Coordinator</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Kanniyan G</td>
                            <td>Asst. Prof., English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Ms. Keerthana J</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Velankanni Amalraj A</td>
                            <td>Administrator</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Vishwa P</td>
                            <td>Student Representative</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Muthu Pandi M</td>
                            <td>Student Representative</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- SAFEGUARDING MORAL AUTHORITY -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">SAFEGUARDING
                                MORAL AUTHORITY</h4>
                            </th>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-style:italic;">(As per the Policy of the Madurai Jesuit
                              Province)</td>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Basil Xavier SSJ</td>
                            <td>Rector</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Antonysamy A SJ</td>
                            <td>Secretary</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>3. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Sundararaj A</td>
                            <td>Deputy Principal</td>
                            <td>Media Spokesperson</td>
                          </tr>
                          <tr>
                            <td>5. Rev. Fr. Sahaya Philominraj SJ</td>
                            <td>Advocate</td>
                            <td>Safeguarding Officer of the Province</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- ARUL ANANDAR INCUBATION CENTRE (AIC) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ARUL ANANDAR
                                INCUBATION CENTRE (AIC)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Justin David C</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Nandakumar E</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Janakiraman V</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Sebastian S</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Revathi P</td>
                            <td>Asst. Prof., FST</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Ms. Annie Jennifer J</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Paul Johnpeter M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Mr. Micheal Naveen Kumar S</td>
                            <td>Asst. Prof., Commerce (Gen)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Ruban Satish A</td>
                            <td>Asst. Prof., Info. Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Kumutha Priya M</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- UNIVERSITY ACTIVITY MONITORING PORTAL (UAMP) COMMITTEE -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">UNIVERSITY
                                ACTIVITY MONITORING PORTAL (UAMP) COMMITTEE</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Bosco J</td>
                            <td>Librarian</td>
                            <td>Nodal Officer</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Primrose K</td>
                            <td>English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Chandra Sekar Pandian S</td>
                            <td>English Lit.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Kalaiselvi A</td>
                            <td>CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- UNNAT BHARAT ABHIYAN CELL (UBA CELL) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">UNNAT BHARAT
                                ABHIYAN CELL (UBA CELL)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Ramkumar G</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Principal Investigator</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Adaikalaraj G</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Co-PI</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Mabel Joshaline C</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Amalraj M</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Parthipan P</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Ms. Annie Jenifer J</td>
                            <td>Asst. Prof., Computer Science</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Dr. Saleth Prabhakar U</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Geno Kadwin J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Mr. Muniyandi K</td>
                            <td>Field Assistant</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- ANTI-DRUG CLUB -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ANTI-DRUG CLUB
                              </h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Michael Raj A</td>
                            <td>Asst. Prof., Commerce</td>
                            <td>Coordinator</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Martin J</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Arockia Maria Micheal Raja A</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Nallakurumban M</td>
                            <td>Asst. Prof., English (SF)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Muthuraja C</td>
                            <td>Asst. Prof., Phy. Edu.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Dr. Vinothkumar R A</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Micheal Naveen Kumar S</td>
                            <td>Asst. Prof., Commerce</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Students Volunteers</td>
                            <td>Members</td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- LEARNING MANAGEMENT SYSTEM -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">LEARNING
                                MANAGEMENT SYSTEM</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Fr. Innaci John V SJ</td>
                            <td>Vice Principal (Shift-II)</td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Bosco J</td>
                            <td>Asst. Prof., CS &amp; CA</td>
                            <td>Co-ordinator</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Geno Kadwin J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Sonia M</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Johnson Stephen I</td>
                            <td>Asst. Prof., English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Ms. Juliet Shanthi I</td>
                            <td>Asst. Prof., CS &amp; CA</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>8. Mr. Albert Irudayaraj J</td>
                            <td>HoD, Information Technology</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>9. Dr. Xavier P</td>
                            <td>Asst. Prof., English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>10. Dr. Kaniselvi M</td>
                            <td>Asst. Prof., Tamil</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>11. Ms. Keerthana J</td>
                            <td>Asst. Prof., CS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>12. Mr. Arockiam R</td>
                            <td>System Administrator</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>13. Mr. Saravanakumar A</td>
                            <td>Web Administrator</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>14. Mr. Bastin Vinoth S</td>
                            <td>Accountant</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>15. Mr. Suresh A</td>
                            <td>Electrician</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- MENTAL WELL-BEING CLUB -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">MENTAL
                                WELL-BEING CLUB</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Justin Kennedy R</td>
                            <td>Asst. Prof., CS&amp;CA</td>
                            <td>Coordinator</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Arockia Maria Micheal Raja A</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Muthu Kumar A</td>
                            <td>Asst. Prof., Phy. Edu.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Nallathambi P</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- COMMITTEE FOR EMPOWERMENT OF PERSONS WITH DISABILITIES -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">COMMITTEE FOR
                                EMPOWERMENT OF PERSONS WITH DISABILITIES</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Martin J</td>
                            <td>Asst. Prof., History</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. M. Paul Johnpeter</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Diana P</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- ACHIEVE (Competitive Examination Cell) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ACHIEVE
                                (Competitive Examination Cell)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. J. Geno Kadwin</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Coordinator</td>
                          </tr>
                          <tr>
                            <td>3. Mr. Bosco J</td>
                            <td>Librarian</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Saleth Prabhakar U</td>
                            <td>Asst. Prof., Chemistry</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Mr. Antony Xavier S</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Dr. Shakila A</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- INDUSTRY RELATION CELL -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">INDUSTRY
                                RELATION CELL</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Michael Venish V</td>
                            <td>Asst. Prof., Economics</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Valanarasu S</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Parthipan P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Arun Prasad S</td>
                            <td>HoD, Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Mr. Albert Irudayaraj J</td>
                            <td>Asst. Prof., IT</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- ALUMNI CONNECT CELL -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">ALUMNI CONNECT
                                CELL</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Mr. Robert Dhiliban J</td>
                            <td>Asst. Prof., Mathematics</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Dr. Nirmal Rajkumar V</td>
                            <td>Asso. Prof., Economics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Sophia J</td>
                            <td>Asst. Prof., Physics</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Benjamin Prabahar I</td>
                            <td>Asst. Prof., Commerce (CA)</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- EQUITABLE OPPORTUNITY CELL -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">EQUITABLE
                                OPPORTUNITY CELL</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Chairperson</td>
                          </tr>
                          <tr>
                            <td>2. Dr. Arul Prasad S</td>
                            <td>Dean - Academic (Arts)</td>
                            <td>Convener</td>
                          </tr>
                          <tr>
                            <td>3. Ms. Sahaya Josephine Mary A</td>
                            <td>HoD, English</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>4. Dr. Nallathambi P</td>
                            <td>Asst. Prof., History</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>5. Dr. Arun Prasad S</td>
                            <td>HoD, Business Admin.</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>6. Ms. Grasi S</td>
                            <td>Office Superintendent</td>
                            <td>Member</td>
                          </tr>
                          <tr>
                            <td>7. Mr. Nirmal Vinod Kumar S</td>
                            <td>Sweeper</td>
                            <td>Member</td>
                          </tr>
                        </tbody>
                      </table>

                      <!-- DR. ARUL LOURDU CENTRE FOR ADVANCEMENT AND RURAL EMPOWERMENT (AL-CARE) -->
                      <table style="min-width: 835px;">
                        <tbody align="left" style="color:#cc5;">
                          <tr>
                            <th colspan="3" style="padding: 0;">
                              <h4 class="btn" style="background-color:#1B9E98;color:#fff;font-size:18pt;">DR. ARUL
                                LOURDU CENTRE FOR ADVANCEMENT AND RURAL EMPOWERMENT (AL-CARE)</h4>
                            </th>
                          </tr>
                          <tr>
                            <td>1. Rev. Dr. Anbarasu M SJ</td>
                            <td>Principal</td>
                            <td>Director</td>
                          </tr>
                          <tr>
                            <td>2. Rev. Dr. Pushparaj G SJ</td>
                            <td>Executive Director &amp; Jesuit In-charge</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>3. Mr. Anthony Raj P</td>
                            <td>Asst. Prof., RDS</td>
                            <td>Asst. Executive Director</td>
                          </tr>
                          <tr>
                            <td>4. Mr. Benedict Prosper</td>
                            <td></td>
                            <td>Staff</td>
                          </tr>
                        </tbody>
                      </table>

                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<button id="backToTopBtn" class="back-to-top-btn" onclick="backToTopSmooth()">↑ Top</button>

<?php
// Footer include removed because footer.php does not
// exist in this project and was causing warnings.
?>