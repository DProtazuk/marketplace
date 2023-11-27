<div class="col-12 d-flex justify-content-between align-items-center p-3">
    <span class="text-white fw-bolder text-14 text_LineChart">Выручка за месяц</span>
    <span class="text-white opacity-25 fw-light fw-bolder">|</span>

    <div class="d-flex align-items-center">
        <div class="elipse_current"></div>
        <span class="text-white text-12 mx-2">Текущая $<span class="current">10,000</span></span>
    </div>

    <div class="d-flex align-items-center">
        <div class="elipse_previous"></div>
        <span class="text-white text-12 mx-2">Предыдущая  $<span class="previous">9,078</span></span>
    </div>

    <div class="dropdown">
        <span class="lh-1 text-white fs-6 fw-bolder cursor" data-bs-toggle="dropdown"
              aria-expanded="false">&bull;&bull;&bull;</span>
        <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25">
            <li>
                <a data-current="4700" data-previous="5500" data-text="неделю" data-canvas="LineChart_week"
                   onclick="point_menu_analytics_LineChart.call(this)"
                   class="cursor dropdown-item point_menu_LineChart">Выручка за неделю</a>
            </li>

            <li>
                <a data-current="4500" data-previous="6000" data-text="месяц" data-canvas="LineChart_month"
                   onclick="point_menu_analytics_LineChart.call(this)" class="cursor dropdown-item point_menu_LineChart active_point_menu">Выручка
                    за месяц</a>
            </li>

            <li>
                <a data-current="8000" data-previous="9000" data-text="год" data-canvas="LineChart_year"
                   onclick="point_menu_analytics_LineChart.call(this)" class="cursor dropdown-item point_menu_LineChart">Выручка
                    за год</a>
            </li>
        </ul>
    </div>
</div>

<div class="col-12 d-flex justify-content-between align-items-center ">
    <canvas class="myLineChart LineChart_week d-none" id="LineChart_week"></canvas>
    <canvas class="myLineChart LineChart_month" id="LineChart_month"></canvas>
    <canvas class="myLineChart LineChart_year d-none" id="LineChart_year"></canvas>
</div>