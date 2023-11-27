//генерация чисел
function getRandomInt(min, max, num) {
    function rand(min, max) {
        return Math.floor(Math.random() * (min - max)) + max;
    }

    let arrayRand_num = [];

    for (let i = 0; i <= num; i++) {
        arrayRand_num.push(rand(min, max, num));
    }
    return arrayRand_num;
}

function chartPayments() {
    let labels_LineChart_week = [null, "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", null];
    let id_LineChart_week = "LineChart_week";

    let label1_LineChart_week = "";
    let label1_color_LineChart_week = "#1877F2";
    let label1_data_LineChart_week = getRandomInt(300, 500, 7);
    // let label1_data_LineChart_week = [null, 15, 20, 50, 35, 40, 42, 50, null];


    LineChart_chartPayments(labels_LineChart_week, id_LineChart_week, label1_LineChart_week, label1_color_LineChart_week, label1_data_LineChart_week);
}



function LineChart_chartPayments(labels_LineChart, id_LineChart, label1_LineChart, label1_color_LineChart, label1_data_LineChart) {
    const multipleLineChart = document.getElementById(id_LineChart).getContext('2d');
    const myMultipleLineChart = new Chart(multipleLineChart, {
        type: 'line',
        data: {
            labels: labels_LineChart,
            datasets: [{
                label: label1_LineChart,
                borderColor: label1_color_LineChart,
                pointBorderColor: label1_color_LineChart,
                pointHoverBorderColor: "#ffffff",
                pointBackgroundColor: label1_color_LineChart,
                pointHoverBackgroundColor: "#ffffff",
                pointBorderWidth: 0,
                pointHoverRadius: 3,
                pointHoverBorderWidth: 3,
                pointRadius: 1,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: label1_data_LineChart,
                lineTension: 0.4  // Устанавливаем значение lineTension для создания плавных переходов
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 5,
                        callback: function(value, index, values) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'k';
                            }
                            return value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            elements: {
                point: {
                    hitRadius: 8,
                    hoverRadius: 5,
                    radius: 1,
                    borderWidth: 5,
                    borderColor: label1_color_LineChart,
                    backgroundColor: 'transparent',
                }
            }
        }
    });

    // Добавляем стиль курсора при наведении
    const canvas = document.getElementById(id_LineChart);
    canvas.style.cursor = 'pointer';
}


function chartRevenue() {
    let labels_LineChart_week = [null, "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", null];
    let id_LineChart_week = "LineChart_revenue";

    let label_LineChart_Revenue_1 = "Продажи";
    let label_color_LineChart_Revenue_1 = "#7E5195";
    let label_data_LineChart_Revenue_1 = getRandomInt(300, 500, 7);
    // let label1_data_LineChart_week = [null, 15, 20, 50, 35, 40, 42, 50, null];

    let label_LineChart_Revenue_2 = "Прибыль";
    let label_color_LineChart_Revenue_2 = "#1877F2";
    let label_data_LineChart_Revenue_2 = getRandomInt(300, 500, 7);

    LineChart_chartRevenue(labels_LineChart_week, id_LineChart_week, label_LineChart_Revenue_1, label_color_LineChart_Revenue_1, label_data_LineChart_Revenue_1, label_LineChart_Revenue_2, label_color_LineChart_Revenue_2, label_data_LineChart_Revenue_2);
}



function LineChart_chartRevenue(labels_LineChart, id_LineChart, label1_LineChart, label1_color_LineChart, label1_data_LineChart, label2_LineChart, label2_color_LineChart, label2_data_LineChart) {
    const multipleLineChart = document.getElementById(id_LineChart).getContext('2d');
    const myMultipleLineChart = new Chart(multipleLineChart, {
        type: 'line',
        data: {
            labels: labels_LineChart,
            datasets: [{
                label: label1_LineChart,
                borderColor: label1_color_LineChart,
                pointBorderColor: label1_color_LineChart,
                pointHoverBorderColor: "#ffffff",
                pointBackgroundColor: label1_color_LineChart,
                pointHoverBackgroundColor: "#ffffff",
                pointBorderWidth: 0,
                pointHoverRadius: 3,
                pointHoverBorderWidth: 3,
                pointRadius: 1,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: label1_data_LineChart,
                lineTension: 0.4  // Устанавливаем значение lineTension для создания плавных переходов
            },
                {
                    label: label2_LineChart,
                    borderColor: label2_color_LineChart,
                    pointBorderColor: label2_color_LineChart,
                    pointHoverBorderColor: "#ffffff",
                    pointBackgroundColor: label2_color_LineChart,
                    pointHoverBackgroundColor: "#ffffff",
                    pointBorderWidth: 0,
                    pointHoverRadius: 3,
                    pointHoverBorderWidth: 3,
                    pointRadius: 1,
                    backgroundColor: 'transparent',
                    fill: true,
                    borderWidth: 2,
                    data: label2_data_LineChart,
                    lineTension: 0.4  // Устанавливаем значение lineTension для создания плавных переходов
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 5,
                        callback: function(value, index, values) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'k';
                            }
                            return value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            elements: {
                point: {
                    hitRadius: 8,
                    hoverRadius: 5,
                    radius: 1,
                    borderWidth: 5,
                    borderColor: label1_color_LineChart,
                    backgroundColor: 'transparent',
                }
            }
        }
    });

    // Добавляем стиль курсора при наведении
    const canvas = document.getElementById(id_LineChart);
    canvas.style.cursor = 'pointer';
}


chartPayments();
chartRevenue();