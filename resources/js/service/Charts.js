function generateBackgroundColor(count) {
    let bgc = [] //background color
    for (let i = 0; i < count; i++) {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        bgc.push(`rgba(${r}, ${g}, ${b}, 0.7)`)
    }
    return bgc
}

export const setBarChartData = (labels, data, bgColors) => {
    return {
        labels: labels,
        datasets: [
            {
                label: 'Age',
                data: data,
                backgroundColor: bgColors,
                borderWidth: 1
            }
        ]
    };
};
export const setBarChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');
    return {
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    // color: surfaceBorder
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    // color: surfaceBorder
                    display: false
                }
            }
        }
    };
}
export const setDoughnutData = (labels, datas, bgColors) => {
    return {
        labels: labels,
        datasets: [
            {   
                data: datas,
                backgroundColor: bgColors,
            }
        ]
    };
};
export const setDoughnutOptions = () => {
    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            layout: {
                padding: 32
            },
            elements: {
                line: {
                    fill: false
                },
                point: {
                    hoverRadius: 7,
                    radius: 5
                }
            },
            legend: {
                labels: {
                    usePointStyle: true
                }
            },
            datalabels: {
                backgroundColor: function (context) {
                    return context.dataset.backgroundColor;
                },
                borderColor: 'white',
                borderRadius: 25,
                borderWidth: 2,
                color: 'white',
                display: function (context) {
                    var dataset = context.dataset;
                    var count = dataset.data.length;
                    var value = dataset.data[context.dataIndex];
                    return value > count;
                },
                font: {
                    weight: 'bold'
                },
                padding: 6,
                formatter: Math.round
            }
        }
    }
}