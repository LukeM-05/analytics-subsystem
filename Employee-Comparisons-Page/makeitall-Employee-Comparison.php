<!DOCTYPE html>
<html lang="en">

<?php
    require_once __DIR__ . '/../config/db_config.php';
    $pdo = getDbConnection();
    $new_employeeId = $_SESSION['employee_id'] ?? 4;
?>

<head>
<title>Employee Comparison</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .backButton {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 40px;
    }

    .dark-mode {
        color: #ffffff;
    }

    body.dark-mode {
        background-color: #1E2330;
    }

    .light-mode {
        color: #000000;
    }

    body.light-mode {
        background-color: #ffffff;
    }

    .light-mode .primaryBackground {
        background-color: #eaeaef;
    }

    .dark-mode .primaryBackground {
        background-color: #2f3648;
    }

    .light-mode .filterDropDownColors {
        background-color: #f8fafc;
    }

    .light-mode .dropdown-item:hover {
        color: black;
        background-color: rgba(131, 131, 131, 0.3);
    }

    .light-mode .dropdown-item:active {
        color: black;
        background-color: rgba(131, 131, 131, 0.3);
    }

    .dark-mode .filterDropDownColors {
        background-color: #1e2330;
    }

    .dark-mode .dropdown-item:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.3);
    }

    .dark-mode .dropdown-item:active {
        color: white;
        background-color: rgba(255, 255, 255, 0.4);
    }

    .light-mode .textColor {
        color: black;
    }

    .dark-mode .textColor {
        color: white;
    }

    .fadedTextColor {
        color: #757575 !important;
    }

    .light-mode .secondaryBackground {
        background-color: #f8fafc;
    }

    .dark-mode .secondaryBackground {
        background-color: #1e2330;
    }

    .graphSelectionButton {
        border-radius: 100px;
        height: 40px;
        width: 40px;
        line-height: 33px;
        font-size: 33px;
        border: none;
        padding: 0;
    }

    .graphSelectionButton:hover {
        background-color: rgba(0,0,0,0.15);
    }

    .graphSectionBackground {
        border-radius: 20px;
        padding: 15px;
    }

    .expandGraphButton {
        border: none;
        height: fit-content;
        font-size: 24px;
        border-radius: 100px;
        padding: 2px 10px 2px;
        display: flex
    }

    .expandGraphButton:hover {
        background-color: rgba(0,0,0,0.15);
    }

    #expandedGraphPopup {
        display: none;
    }

    .darkendBackgroundForPopups {
        width: 100%;
        height: 100%;
        position: fixed;
        transform: translate(-50%,-50%);
        top: 50%;
        left: 50%;
        background-color: rgba(0, 0, 0, 0.6);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .graphPopup {
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        position: fixed;
        height: 80%;
        width: 80%;
    }

    .closeButton {
        border: none;
        border-radius: 50%;
        width: 54px;
        height: 54px;
        font-size: 2.1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;

        position: absolute;
        right: 15px
    }

    .dark-mode .buttonBg {
        background-color: #252B3B;
    }

    .light-mode .buttonBg {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .dropDownText {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dropDownButton {
        border-radius: 100px;
        border: none;
        padding: 2px 10px 2px;
        font-size: 24px;
        width: 160px;
        display: flex;
        justify-content: space-between;
        place-items: center;
    }

    .infoPopup {
        font-weight: normal;
        position: absolute;
        top: 100%;
        border-radius: 25px;
        padding: 20px;
        text-align: start;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        opacity: 0;
        display: none;
        z-index: 1;
        transition: opacity 0.4s, visibility 0s linear 0.4s;
    }

    .light-mode .infoIcon {
        color: #f8fafc;
        background-color: #808080;
        font-size: 30px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        text-align: center;
        font-weight: bold;
        border: none;
        position:relative;
    }
    .dark-mode .infoIcon {
        color: #2F3648;
        background-color: white;
        font-size: 30px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        text-align: center;
        font-weight: bold;
        border: none;
        position:relative;
    }

    .removeForSmallScreen {
        display: block;
    }

    .fillScreenForSmallScreen {
        width: 70%;
    }

    #projectSectionsGrid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .dark-mode .contrastingThemeColor {
        background-color: white;
    }

    .light-mode .contrastingThemeColor {
        background-color: black;
    }

    .showForSmallScreen {
        display: none;
    }

    @media (max-width: 992px) {
        .removeForSmallScreen {
            display: none;
        }
        .unFlexForSmallScreen {
            flex-direction: column;
        }
        #projectSectionsGrid {
            display: flex;
            flex-direction: column;
        }
        .showForSmallScreen {
            display: block;
        }
    }

    @media (max-width: 1200px) {
        .unFlexForMediumSizedScreen {
            flex-direction: column;
        }
    }

    @media (max-width: 1600px) {
        .unFlexForOverview {
            flex-direction: column;
        }
        .fillScreenForSmallScreen {
            width: 100%;
        }
    }

    .dark-mode .activeButton {
        background-color: #D2D2DB;
        color: black;
        transition: background-color 0.4s;
    }

    .light-mode .activeButton {
        background-color: #CCCCCC;
        color: black;
        transition: background-color 0.4s;
    }

    canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>

</head>

<body onload="loadProjectDropDownOptions()" class="light-mode bodyBackgroundColor">

    <div style="z-index: 100; position: relative;">
        <?php
            require "../navbar/navbar.php";
        ?>
    </div>
    
    <!--back button and Compare Projects text-->
    <div style="padding: 20px 20px 0px 20px; display: flex">
        <button class="backButton textColor" type="button" onclick="history.back()"><i class="bi bi-arrow-left"></i></button>
        <div style="width: 20px"></div>
        <p style="font-size: 40px; margin: 0">Compare Employees</p>
    </div>
    
    <div style="padding: 30px">
        <!--project selection div-->
        <div class="primaryBackground" style="padding: 10px 30px 10px; border-radius: 20px;">
            <div style="display: flex; place-items: center;">
                <p style="font-size: 40px; margin: 0;">Select Project:</p>

                <div style="width: 25px"></div>

                <div class="dropdown">
                    <button id="projectDropDown" class="dropdown-toggle filterDropDownColors textColor dropDownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fadedTextColor">None</span>
                    </button>
                    <!-- drop down options -->
                    <ul id="projectDropDownOptions" style="border-radius: 15px; overflow: auto; max-height: 500px" class="dropdown-menu filterDropDownColors">
                        

                    </ul>
                </div>
            </div>
            
            
        </div>

        <div style="height: 20px;"></div>

        <!--projects selection div-->
        <div class="primaryBackground" style="padding: 30px; border-radius: 20px;">
            <p style="font-size: 40px; margin: 0;">Select Up To 4 Employees</p>

            <div style="place-items: center;">
                <div class="unFlexForSmallScreen" style="display: flex; gap: 40px;">

                    <!--project selector for project 1-->
                    <div>
                        <p style="font-size: 28px; margin: 0; font-weight: bold; text-align: center;">Employee 1:</p>
                        <div style="place-items: center;">
                            <div class="dropdown">
                                <button id="project1" class="dropdown-toggle filterDropDownColors textColor dropDownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fadedTextColor">None</span>
                                </button>
                                <!-- drop down options -->
                                <ul id="project1_dropDown" style="border-radius: 15px; overflow: auto; max-height: 500px" class="dropdown-menu filterDropDownColors">
                                   

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--project selector for project 2-->
                    <div>
                        <p style="font-size: 28px; margin: 0; font-weight: bold; text-align: center;">Employee 2:</p>
                        <div style="place-items: center;">
                            <div class="dropdown">
                                <button id="project2" class="dropdown-toggle filterDropDownColors textColor dropDownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fadedTextColor">None</span>
                                </button>
                                <!-- drop down options -->
                                <ul id="project2_dropDown" style="border-radius: 15px; overflow: auto; max-height: 500px" class="dropdown-menu filterDropDownColors">
                                   

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--project selector for project 3-->
                    <div>
                        <p style="font-size: 28px; margin: 0; font-weight: bold; text-align: center;">Employee 3:</p>
                        <div style="place-items: center;">
                            <div class="dropdown">
                                <button id="project3" class="dropdown-toggle filterDropDownColors textColor dropDownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fadedTextColor">None</span>
                                </button>
                                <!-- drop down options -->
                                <ul id="project3_dropDown" style="border-radius: 15px; overflow: auto; max-height: 500px" class="dropdown-menu filterDropDownColors">
                                    

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--project selector for project 4-->
                    <div>
                        <p style="font-size: 28px; margin: 0; font-weight: bold; text-align: center;">Employee 4:</p>
                        <div style="place-items: center;">
                            <div class="dropdown">
                                <button id="project4" class="dropdown-toggle filterDropDownColors textColor dropDownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fadedTextColor">None</span>
                                </button>
                                <!-- drop down options -->
                                <ul id="project4_dropDown" style="border-radius: 15px; overflow: auto; max-height: 500px" class="dropdown-menu filterDropDownColors">
                                    

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div style="height: 10px;"></div>
        </div>

        <div style="height: 20px;"></div>

        <div class="primaryBackground" style="padding: 20px; border-radius: 20px;">
            <div style="display: flex;" class="unFlexForSmallScreen">
                <div style="width: 100%;">
                    <p style="font-size: 28px; margin: 0; font-weight: bold;">Current Graph:</p>

                    <div style="height: 5px;"></div>

                    <div id="rowOfButtons" class="unFlexForMediumSizedScreen" style="display: flex; gap: 15px; flex-wrap: wrap;">
                        
                        
                    </div>
                </div>

                <div>
                    <div style="float: right">
                        <p style="font-size: 28px; margin: 0; font-weight: bold; white-space: pre;">Sort Projects By:</p>
                        <div class="dropdown" style="float: right;">
                            <button id="sortProjectsDropDownButton" class="dropdown-toggle filterDropDownColors textColor" style="border-radius: 100px; border: none; padding: 2px 10px 2px; font-size: 22px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Most Progress
                            </button>
                            <!-- drop down options -->
                            <ul style="border-radius: 15px;" class="dropdown-menu filterDropDownColors">
                                <li onclick="sortProjectsDropDownUpdate(`Most Progress`)"><a class="dropdown-item textColor" style="font-size: 22px;">Most Progress</a></li>
                                <li onclick="sortProjectsDropDownUpdate(`Least Progress`)"><a class="dropdown-item textColor" style="font-size: 22px;">Least Progress</a></li>
                                <li onclick="sortProjectsDropDownUpdate(`Most Tasks Done`)"><a class="dropdown-item textColor" style="font-size: 22px;">Most Tasks Done</a></li>
                                <li onclick="sortProjectsDropDownUpdate(`Least Tasks Done`)"><a class="dropdown-item textColor" style="font-size: 22px;">Least Tasks Done</a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div style="height: 40px;"></div>

        <!--grid to display graph for each selected project-->
        <div id="projectSectionsGrid">    


        </div>

    </div>

    <!--graph pop up-->
    <div id="expandedGraphPopup">
        <div class="darkendBackgroundForPopups"></div>
        <div class="primaryBackground graphPopup" style="display: flex; flex-direction: column; padding: 0px 30px 30px 30px; border-radius: 20px;">
            <!--graph name and x button-->
            <div style="display: flex; justify-content: space-between; padding-top: 5px; place-items: center;">
                <p id="popupGraphTitle" style="font-size: 36px; margin: 0; padding: 5px 0px 5px;">Graph Name</p>
                <button onclick="closeExpandedGraphPopup()" class="textColor closeButton buttonBg">✕</button>
            </div>
            <!--graph canvas-->
            <div class="secondaryBackground" style="width: 100%; height: 100%; border-radius: 20px; padding: 10px; overflow: auto;">
                <div id="expadedCanvasContainer">
                    <canvas id="expandedGraphCtx"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!--script tag below-->

    <script>
        let userId = <?php echo json_encode($new_employeeId); ?>;
    </script>

    <script>
        async function getWithUrl(url) {
            const response = await fetch(url);
            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error);
            }

            return result.data;
        }

        //function to close expandedGraphPopup
        function closeExpandedGraphPopup() {
            document.getElementById("expandedGraphPopup").style.display = "none";
        }

        //function to update the project selector drop downs
        async function projectsDropDownUpdate(projectNum, dropDownText, projectId, globalProjectId) {
            await (async () => {
                if (dropDownText == "None") {
                    document.getElementById(`${projectNum}`).innerHTML = `<span class="fadedTextColor">None</span>`;
                    removeFromProjectsList(projectNum);
                } else {
                    document.getElementById(`${projectNum}`).innerHTML = `<span class="dropDownText">${dropDownText}</span>`;
                    await addToProjectsList(projectNum, projectId, dropDownText, globalProjectId);
                }

                sortProjectsDropDownUpdate(document.getElementById("sortProjectsDropDownButton").textContent);
                loadProjectSections();
            })();
        }

        function projectDropDownUpdate(dropDownText, projectId) {
            if (dropDownText == "None") {
                document.getElementById("projectDropDown").innerHTML = `<span class="fadedTextColor">None</span>`;
                clearEmployeeDropDownOptions();
            } else {
                document.getElementById("projectDropDown").innerHTML = `<span class="dropDownText">${dropDownText}</span>`;
                loadEmployeeDropDownOptions(projectId);
            }
        }

        let sortedProjectsList = [];

        //function to update the project selector drop downs
        function sortProjectsDropDownUpdate(sortMethod) {
            document.getElementById("sortProjectsDropDownButton").textContent = sortMethod;

            let newSortedProjectsList = [];
            for (project of employeesList) {
                if (project != null) {
                    newSortedProjectsList.push(project)
                }
            }

            sortedProjectsList = newSortedProjectsList;

            if (sortMethod == "Most Progress") {
                sortedProjectsList.sort((a,b) => parseFloat(a.progress) - parseFloat(b.progress));
            } else if (sortMethod == "Least Progress") {
                sortedProjectsList.sort((a,b) => parseFloat(b.progress) - parseFloat(a.progress));
            } else if (sortMethod == "Most tasks done") {
                sortedProjectsList.sort((a,b) => a.tasksDone - b.tasksDone);
            } else if (sortMethod == "Least Tasks Done") {
                sortedProjectsList.sort((a,b) => b.tasksDone - a.tasksDone);
            }

            loadProjectSections();
        }

        let EG_chartObject;
        function expandGraph(projectId) {

            if (EG_chartObject) {
                EG_chartObject.destroy();
            }

            let project;
            for (projectObject of employeesList) {
                if (projectObject != null) {
                    if (projectId == projectObject.id) {
                        project = projectObject;
                    }
                }
            }

            //adjust width if needed
            let graphWidth;
            if (graphType == "teamProductivityRate") {
                const maxMemberCountBeforeScroll = 10;
                if (project.employees.length > maxMemberCountBeforeScroll) {
                    const newWidth = (project.employees.length / maxMemberCountBeforeScroll) * 100
                    graphWidth = newWidth + "%";
                } else {
                    graphWidth = "100%";
                }
            } else {
                graphWidth = "100%";
            }
            document.getElementById("expadedCanvasContainer").style.width = graphWidth;

            //adjust height if needed
            const projectTasksList = project.tasks;
            let graphHeight;
            if (graphType == "ganttChart") {
                const maxNumberOfTasksBeforeScroll = 15;
                if (projectTasksList.length > maxNumberOfTasksBeforeScroll) {
                    const newHeight = (projectTasksList.length / maxNumberOfTasksBeforeScroll) * 100
                    graphHeight = newHeight + "%";
                } else {
                    graphHeight = "100%";
                }
            } else {
                graphHeight = "100%";
            }
            document.getElementById("expadedCanvasContainer").style.height = graphHeight;

            let graphTitle;

            const ctx = document.getElementById("expandedGraphCtx");
            if (graphType == "actualExpectedCompletions") {
                generate_actualExpectedCompletions(ctx, project.id, true);
                graphTitle = "Actual / Expected Completions";
            } else if (graphType == "estEffortAccuracy") {
                generate_estEffortAccuracy(ctx, project.id, true);
                graphTitle = "Effort Estimation Accuracy";
            } else if (graphType == "ganttChart") {
                generate_ganttChart(ctx, project.id, true);
                graphTitle = "Gantt Chart";
            } else if (graphType == "teamProductivityRate") {
                generate_teamProductivityRate(ctx, project.id, true);
                graphTitle = "Team Productivity Rate";
            } else if (graphType == "taskStatusBars") {
                generate_taskStatusBars(ctx, project.id, true);
                graphTitle = "Task Status Bars";
            }

            document.getElementById("popupGraphTitle").innerHTML = graphTitle;
            document.getElementById("expandedGraphPopup").style.display = "block";
        }

        let graphTypesList = ["overview", "actualExpectedCompletions", "estEffortAccuracy", "ganttChart", "taskStatusBars"];

        let pressedButton = "overview_button";

        function updateGraphType(newGraphType) {
            document.getElementById(pressedButton).classList.add("secondaryBackground");
            document.getElementById(pressedButton).classList.remove("activeButton");

            graphType = newGraphType;
            if (newGraphType == "overview") {
                document.getElementById("overview_button").classList.add("activeButton");
                document.getElementById("overview_button").classList.remove("secondaryBackground");
                pressedButton = "overview_button";
            } else if (newGraphType == "actualExpectedCompletions") {
                document.getElementById("actualExpectedCompletions_button").classList.add("activeButton");
                document.getElementById("actualExpectedCompletions_button").classList.remove("secondaryBackground");
                pressedButton = "actualExpectedCompletions_button";
            } else if (newGraphType == "estEffortAccuracy") {
                document.getElementById("estEffortAccuracy_button").classList.add("activeButton");
                document.getElementById("estEffortAccuracy_button").classList.remove("secondaryBackground");
                pressedButton = "estEffortAccuracy_button";
            } else if (newGraphType == "ganttChart") {
                document.getElementById("ganttChart_button").classList.add("activeButton");
                document.getElementById("ganttChart_button").classList.remove("secondaryBackground");
                pressedButton = "ganttChart_button";
            } else if (newGraphType == "teamProductivityRate") {
                document.getElementById("teamProductivityRate_button").classList.add("activeButton");
                document.getElementById("teamProductivityRate_button").classList.remove("secondaryBackground");
                pressedButton = "teamProductivityRate_button";
            } else if (newGraphType == "taskStatusBars") {
                 document.getElementById("taskStatusBars_button").classList.add("activeButton");
                document.getElementById("taskStatusBars_button").classList.remove("secondaryBackground");
                pressedButton = "taskStatusBars_button";
            }
            
            loadProjectSections();
        }

        function makeCumulative(list) {
            let previousYValue = 0;
            for (item of list) {
                if (previousYValue) {
                    item.y = item.y + previousYValue;
                }
                previousYValue = item.y;
            }
        }

        //converts esteffort symbol into the hours
        function getEstEffortFromSymbol(symbol) {
            if (symbol == "XS") {
                return 1;
            } else if (symbol == "S") {
                return 4;
            } else if (symbol == "M") {
                return 8;
            } else if (symbol == "L") {
                return 24;
            } else if (symbol == "XL") {
                return 40;
            }
        }

        function generate_estEffortAccuracy(ctx, projectId, forExpanded) {
            //getting project from project id
            let project;
            for (projectItem of employeesList) {
                if (projectItem != null) {
                    if (projectItem.id == projectId) {
                        project = projectItem;
                    }
                }
            }

            let tasksList = project.EEA_tasks;

            let completedTasks = [];
            for (task of tasksList) {
                if (task.completed_date != null) {
                    completedTasks.push(task);
                }
            }

            completedTasks.sort((a,b) => new Date(a.completed_date) - new Date(b.completed_date));

            const labels = completedTasks.map(t => {
                const d = new Date(t.completed_date);
                return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
            });

            const ratios = completedTasks.map(t =>
                parseFloat((t.actual_effort_hours / t.estimated_effort_hours).toFixed(2))
            );

            const barColors   = ratios.map(r => r <= 1 ? 'rgba(0, 191, 99, 0.85)'  : r <= 1.5 ? 'rgba(232, 118, 47, 0.85)'  : 'rgba(220, 52, 52, 0.85)');
            const hoverColors = ratios.map(r => r <= 1 ? '#00BF63'                   : r <= 1.5 ? '#E8762F'                   : '#DC3434');

            //colors for the graph grid and ticks depending on whether light mode or dark mode is enabled
            let chartTicksColor;
            let chartGridColor;
            let toolTipBgColor;
            let toolTipBorderColor;
            let toolTipTitleColor;
            let toolTipBodyColor;
            if (document.body.classList.contains("dark-mode")) {
                chartTicksColor = "white";
                chartGridColor = "rgba(255,255,255,0.2)";
                toolTipBgColor = '#1C2131';
                toolTipBorderColor = '#3a3f4b';
                toolTipTitleColor = '#e8ecf5';
                toolTipBodyColor = '#a0aabf';
            } else {
                chartTicksColor = "black";
                chartGridColor = "rgba(0,0,0,0.2)";
                toolTipBgColor = '#f8fafc';
                toolTipBorderColor = "black";
                toolTipTitleColor = "black";
                toolTipBodyColor = "black";
            }

            //get the current graph chart and destroy it
            if (forExpanded == false) {
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == projectId) {
                        if (graphIdAndChart[1] != null) {
                            graphIdAndChart[1].destroy();
                        }
                    }
                }
            }

            //the graph itself
            let chartObject = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            borderRadius: 8,
                            borderSkipped: false, // adds border radius to all sides of the bar
                            data: ratios,
                            backgroundColor: barColors,
                            hoverBackgroundColor: hoverColors,
                            borderWidth: 1
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: `${toolTipBgColor}`,
                            borderColor: `${toolTipBorderColor}`,
                            titleColor: `${toolTipTitleColor}`,
                            bodyColor: `${toolTipBodyColor}`,
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            titleFont: { family: 'Lexend Deca', weight: '600', size: 20 },
                            bodyFont: { family: 'Lexend Deca', size: 20 },

                            callbacks: {
                                title: items => {
                                    const t = completedTasks[items[0].dataIndex];
                                    return t.title.length > 32 ? t.title.slice(0, 32) + '…' : t.title;
                                },
                                label: context => {
                                    const t     = completedTasks[context.dataIndex];
                                    const ratio = context.parsed.y;
                                    return [
                                    ` Actual: ${t.actual_effort_hours.toFixed(2)}h`,
                                    ` Estimated: ${t.estimated_effort_hours.toFixed(2)}h`,
                                    ` Ratio: ${ratio}x (${ratio <= 1 ? 'Under estimate' : 'Over estimate'})`,
                                    ];
                                }
                            },
                        }
                    },
                    scales: {
                        x: {
                            ticks: { //make the ticks (little lables on the x axis) have a bigger font size and change the color of them
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the grid color for the x axis
                                color: `${chartGridColor}`
                            },
                            stacked: true, //make the graph stacked for x axis
                        },
                        y: {
                            border: {
                                display: true,
                                color: `${chartGridColor}`
                            },

                            title: {
                                display: true, // display the graph title for the y axis
                                text: "Actual / Estimated Ratio",//changed the font size, set the text for the title and changed the color
                                font: {
                                    family: 'Lexend Deca',
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the grid color for the y axis
                                color: `${chartGridColor}`
                            },
                            ticks: { //make the ticks (little lables on the y axis) have a bigger font size and change the color of them
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                        }
                    }
                },
                plugins: [{
                    id: 'baselineLine',
                    afterDraw(chart) {
                    const { ctx, chartArea, scales } = chart;
                    const y1 = scales.y.getPixelForValue(1);
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(chartArea.left, y1);
                    ctx.lineTo(chartArea.right, y1);
                    ctx.strokeStyle = 'rgba(255,255,255,0.2)';
                    ctx.lineWidth   = 1.5;
                    ctx.setLineDash([5, 4]);
                    ctx.stroke();
                    ctx.setLineDash([]);
                    ctx.font      = '600 9px Lexend Deca, sans-serif';
                    ctx.fillStyle = 'rgba(255,255,255,0.3)';
                    ctx.textAlign = 'right';
                    ctx.fillText('1x (on estimate)', chartArea.right - 4, y1 - 5);
                    ctx.restore();
                    }
                }]
            });

            if (forExpanded == true) {
                EG_chartObject = chartObject
            } else {
                //update the current graph chart in the currentGraphIdsAndCharts list
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == projectId) {
                        graphIdAndChart[1] = chartObject;
                    }
                }
            }
        }

        let currentGraphIdsAndCharts = [];

        function generate_actualExpectedCompletions(ctx, projectId, forExpanded) {
            //getting project from project id
            let project;
            for (projectItem of employeesList) {
                if (projectItem != null) {
                    if (projectItem.id == projectId) {
                        project = projectItem;
                    }
                }
            }

            let tasksListSorted = structuredClone(project.tasks);
            tasksListSorted.sort((a,b) => new Date(a.start_date) - new Date(b.start_date));

            let taskEndDates = [] //used to get the maximum task end date to set the max value for the x axis on the graph

            let actualCompDatesWithWeights = [];
            //used for the tool tip
            let actualCompTaskNames = [];
            let actualCompEstEfforts = [];

            let expectedCompDatesWithWeights = [];
            //used for the tool tip
            let expectedCompTaskNames = [];
            let expectedCompEstEfforts = [];

            for (task of tasksListSorted) {
                //used to get the maximum task end date
                taskEndDates.push(new Date(task.gantt_end_date));
                
                //if task has a completed date, it is completed so add it to the actualCompletionDates list
                if (task.completed_date != null) {
                    actualCompDatesWithWeights.push({x:(task.completed_date), y:(getEstEffortFromSymbol(task.estimated_effort))});
                    actualCompTaskNames.push(task.title);
                    actualCompEstEfforts.push(task.estimated_effort);
                } else {
                    //if task doesnt have a completed date is not completed so add the due date to the expectedCompletedDates list
                    expectedCompDatesWithWeights.push({x:(task.due_date), y:(getEstEffortFromSymbol(task.estimated_effort))});
                    expectedCompTaskNames.push(task.title);
                    expectedCompEstEfforts.push(task.estimated_effort);
                }
            }
            
            const minTaskStartDate = new Date(project.start_date);

            taskEndDates.push(new Date(project.due_date));
            const maxTaskEndDate = new Date(Math.max(...taskEndDates)); //no idea why the ... is there but Math.max doesn't work without it

            makeCumulative(actualCompDatesWithWeights); //make the weights cumulative for both of the datasets
            makeCumulative(expectedCompDatesWithWeights);

            //add minTaskStartDate with a weight of 0 so the line charts start at 0 and then will go up to the weight of the next task later
            //otherwise the line will start at the first task completion at a weight that is not 0
            actualCompDatesWithWeights.unshift({x: minTaskStartDate, y: 0});
            expectedCompDatesWithWeights.unshift({x: minTaskStartDate, y: 0});

            //add project start and N/A for the est effort to the actual / expected task names and est effort variables
            actualCompTaskNames.unshift("Project Start");
            expectedCompTaskNames.unshift("Project Start");
            actualCompEstEfforts.unshift("N/A");
            expectedCompEstEfforts.unshift("N/A");

            let projectDurationMonths = (maxTaskEndDate - minTaskStartDate) / (1000 * 60 * 60 * 24 * 7 * 4);    
            let timeUnitTitle; //title that shows up on the x axis

            //change graph's time unit based on how long the project duration is
            if (projectDurationMonths < 0.5) {
                timeUnit = "day";
                timeUnitTitle = "Days";
            } else if (projectDurationMonths < 6) {
                timeUnit = "week";
                timeUnitTitle = "Weeks";
            } else if (projectDurationMonths < 36) {
                timeUnit = "month";
                timeUnitTitle = "Months";
            } else {
                timeUnit = "year";
                timeUnitTitle = "Years";
            }

            //reset the graph's width and height incase it has been changed by another graph
            //innerGraphsContainer.style.height = "100%";
            //innerGraphsContainer.style.width = "100%";


            //colors for the graph grid and ticks depending on whether light mode or dark mode is enabled
            let chartTicksColor;
            let chartGridColor;
            let toolTipBgColor;
            let toolTipBorderColor;
            let toolTipTitleColor;
            let toolTipBodyColor;
            if (document.body.classList.contains("dark-mode")) {
                chartTicksColor = "white";
                chartGridColor = "rgba(255,255,255,0.2)";
                toolTipBgColor = '#1C2131';
                toolTipBorderColor = '#3a3f4b';
                toolTipTitleColor = '#e8ecf5';
                toolTipBodyColor = '#a0aabf';
            } else {
                chartTicksColor = "black";
                chartGridColor = "rgba(0,0,0,0.2)";
                toolTipBgColor = '#f8fafc';
                toolTipBorderColor = "black";
                toolTipTitleColor = "black";
                toolTipBodyColor = "black";
            }

            //get the current graph chart and destroy it
            if (forExpanded == false) {
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        if (graphIdAndChart[1] != null) {
                            graphIdAndChart[1].destroy();
                        }
                    }
                }
            }

            //the graph itself
            let chartObject = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [
                        {
                        label: 'Actual Completion',
                        data: actualCompDatesWithWeights,
                        borderColor: `${chartTicksColor}`,
                        backgroundColor: `${chartTicksColor}`,
                        borderWidth: 1
                        },
                        {
                        label: 'Expected Completion',
                        data: expectedCompDatesWithWeights,
                        borderColor: "#3578D5",
                        backgroundColor: "#3578D5",
                        borderWidth: 1
                        },
                ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: "linear", //make the x axis linear and set the first and last points for it
                            min: minTaskStartDate,
                            max: maxTaskEndDate,
                            
                            title: { //display the title for the x axis, set the text, and change the font size as well as the color
                                display: true,
                                text: `${timeUnitTitle}`,
                                font: {
                                    family: 'Lexend Deca',
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the color for the x axis grid
                                color: `${chartGridColor}`
                            },
                            ticks: { //change the font size of the ticks and the color
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                                type: "time", //set the x axis's type as time and set the time unit
                                time: {
                                    unit: `${timeUnit}`
                                }
                        },
                        y: {
                            border: {
                                display: true,
                                color: `${chartGridColor}`
                            },

                            title: { //display the title for the y axis, set the text and change font size and color
                                display: true,
                                text: "Weighted Tasks Done",
                                font: {
                                    family: 'Lexend Deca',
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            beginAtZero: true,
                            grid: { //change the grid color for the y axis
                                color: `${chartGridColor}`
                            },
                            ticks: { //change the font size and color the ticks for the y axis
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                        }
                    },
                    plugins: {
                        legend: { //change the color and font size of the legend
                            labels: {
                                color: `${chartTicksColor}`,
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                            }
                        },
                        //custom tool tip displaying task name, est effort and completion date
                        tooltip: {
                            backgroundColor: `${toolTipBgColor}`,
                            borderColor: `${toolTipBorderColor}`,
                            titleColor: `${toolTipTitleColor}`,
                            bodyColor: `${toolTipBodyColor}`,
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            titleFont: { family: 'Lexend Deca', weight: '600', size: 20 },
                            bodyFont: { family: 'Lexend Deca', size: 20 },
                            callbacks: {
                                title: ((context) => {
                                    if (context[0].dataset.label == "Expected Completion") {
                                        return[expectedCompTaskNames[context[0].dataIndex]];
                                    } else {
                                        return[actualCompTaskNames[context[0].dataIndex]];
                                    }
                                    //if you're hovering over for example the 2nd datapoint it will get the task name of it in the respective dataset
                                }),
                                label: ((context) => {
                                    //shows the est effort and the completion dates
                                    if (context.dataset.label == "Expected Completion") {
                                        return["Estimated Effort: " + expectedCompEstEfforts[context.dataIndex], "Completion Date: " + context.dataset.data[context.dataIndex].x];
                                    } else {
                                        return["Estimated Effort: " + actualCompEstEfforts[context.dataIndex], "Completion Date: " + context.dataset.data[context.dataIndex].x];
                                    }
                                }),
                                
                            }
                        }
                    }
                }
            });
            if (forExpanded == true) {
                EG_chartObject = chartObject
            } else {
                //update the current graph chart in the currentGraphIdsAndCharts list
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        graphIdAndChart[1] = chartObject;
                    }
                }
            }
        }

        function generate_ganttChart(ctx, projectId, forExpanded) {
            //getting project from project id
            let project;
            for (projectItem of employeesList) {
                if (projectItem != null) {
                    if (projectItem.id == projectId) {
                        project = projectItem;
                    }
                }
            }

            let tasksListSorted = structuredClone(project.tasks);
            tasksListSorted.sort((a,b) => new Date(a.gantt_start_date) - new Date(b.gantt_start_date));

            let taskNames = [];

            let NS_taskStartEndDates = [];
            let IP_taskStartEndDates = [];
            let C_taskStartEndDates = [];
            let AV_taskStartEndDates = [];
            //the reason there are multiple datasets is to allow the user to filter which type of tasks they want to see by status
            
            //the gantt chart bars are displayed as stacked so each of the above variables must contain the same amount of elements so some are null

            let taskEndDates = []; //used to calculate the last point on the x axis for the graph by getting the last value of this array
            
            let allTaskDates = []; //used to adjust the width of the graph

            for (task of tasksListSorted) {
                taskNames.push(task.title);
                taskEndDates.push(new Date(task.gantt_end_date));
                allTaskDates.push([task.gantt_start_date, task.gantt_end_date]);

                //add start and end dates of each task to the dataset they belong to (based on their status)
                if (task.status == "Not Started") {
                    NS_taskStartEndDates.push([task.gantt_start_date, task.gantt_end_date]);
                    //fill rest with empty start and end dates
                    IP_taskStartEndDates.push([0,0]);
                    C_taskStartEndDates.push([0,0]);
                    AV_taskStartEndDates.push([0,0]);
                } else if (task.status == "In Progress") {
                    IP_taskStartEndDates.push([task.gantt_start_date, task.gantt_end_date]);
                    //fill rest with empty start and end dates
                    NS_taskStartEndDates.push([0,0]);
                    C_taskStartEndDates.push([0,0]);
                    AV_taskStartEndDates.push([0,0]);
                } else if (task.status == "Completed") {
                    C_taskStartEndDates.push([task.gantt_start_date, task.gantt_end_date]);
                    //fill rest with empty start and end dates
                    NS_taskStartEndDates.push([0,0]);
                    IP_taskStartEndDates.push([0,0]);
                    AV_taskStartEndDates.push([0,0]);
                } else if (task.status == "Awaiting Validation") {
                    AV_taskStartEndDates.push([task.gantt_start_date, task.gantt_end_date]);
                    //fill rest with empty start and end dates
                    NS_taskStartEndDates.push([0,0]);
                    IP_taskStartEndDates.push([0,0]);
                    C_taskStartEndDates.push([0,0]);
                }
            }

            const minTaskStartDate = new Date(project.start_date); //used to set the first value on the x axis. otherwise it started from a weird time
            
            taskEndDates.push(new Date(project.due_date)); //incase the project is completed before time, the project due date may be the last item on the x axis
            const maxTaskEndDate = new Date(Math.max(...taskEndDates)); //no idea why the ... is there but Math.max doesn't work without it

            let projectDurationMonths = (maxTaskEndDate - minTaskStartDate) / (1000 * 60 * 60 * 24 * 7 * 4);    
            let timeUnit;
            let timeUnitTitle; //title that shows up on the x axis

            //change graph's time unit based on how long the project duration is
            if (projectDurationMonths < 0.5) {
                timeUnit = "day";
                timeUnitTitle = "Days";
            } else if (projectDurationMonths < 6) {
                timeUnit = "week";
                timeUnitTitle = "Weeks";
            } else if (projectDurationMonths < 36) {
                timeUnit = "month";
                timeUnitTitle = "Months";
            } else {
                timeUnit = "year";
                timeUnitTitle = "Years";
            }

            //colors for the graph grid and ticks depending on whether light mode or dark mode is enabled
            let chartTicksColor;
            let chartGridColor;
            let toolTipBgColor;
            let toolTipBorderColor;
            let toolTipTitleColor;
            let toolTipBodyColor;
            if (document.body.classList.contains("dark-mode")) {
                chartTicksColor = "white";
                chartGridColor = "rgba(255,255,255,0.2)";
                toolTipBgColor = '#1C2131';
                toolTipBorderColor = '#3a3f4b';
                toolTipTitleColor = '#e8ecf5';
                toolTipBodyColor = '#a0aabf';
            } else {
                chartTicksColor = "black";
                chartGridColor = "rgba(0,0,0,0.2)";
                toolTipBgColor = '#f8fafc';
                toolTipBorderColor = "black";
                toolTipTitleColor = "black";
                toolTipBodyColor = "black";
            }

            //get the current graph chart and destroy it
            if (forExpanded == false) {
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        if (graphIdAndChart[1] != null) {
                            graphIdAndChart[1].destroy();
                        }
                    }
                }
            }

            //the graph itself
            let chartObject = new Chart(ctx, {
                type: 'bar',
                data: {
                labels: taskNames, // your task names
                datasets: [
                    {
                        label: 'Not Started',
                        borderRadius: 8,
                        borderSkipped: false,
                        data: NS_taskStartEndDates,
                        backgroundColor: "#DC3434",
                        borderWidth: 1
                        },
                        {
                        label: 'In Progress',
                        borderRadius: 8,
                        borderSkipped: false,
                        data: IP_taskStartEndDates,
                        backgroundColor: "#E8762F",
                        borderWidth: 1
                        },
                        {
                        label: 'Completed',
                        borderRadius: 8,
                        borderSkipped: false,
                        data: C_taskStartEndDates,
                        backgroundColor: "#00BF63",
                        borderWidth: 1
                        },
                        {
                        label: 'Awaiting Validation',
                        borderRadius: 8,
                        borderSkipped: false,
                        data: AV_taskStartEndDates,
                        backgroundColor: "#3578D5",
                        borderWidth: 1
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: "y",
                    scales: {
                        x: {
                            min: minTaskStartDate, //set the first and last numbers on the x axis
                            max: maxTaskEndDate,
                            
                            title: {
                                display: true, //display the title and set the text for it + change the font size and color
                                text: `${timeUnitTitle}`,
                                font: {
                                    family: 'Lexend Deca',
                                    size: 30
                                },
                                color: `${chartTicksColor}`
                            },
                            ticks: { //change the ticks font size and color
                                font: {
                                    family: 'Lexend Deca',
                                    size: 20
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the grid color for the x axis
                                color: `${chartGridColor}`
                            },
                            type: "time", //set the x axis type as time and set this unit *Note this required some import if you scroll all the way at the bottom next to the other chart js import, it should be there
                            time: {
                                unit: `${timeUnit}`
                            }
                        },
                        y: {
                            border: {
                                display: true,
                                color: `${chartGridColor}`
                            },

                            title: { //display the y axis title and set the font + color
                                display: true,
                                text: "Tasks",
                                font: {
                                    family: 'Lexend Deca',
                                    size: 30
                                },
                                color: `${chartTicksColor}`
                            },
                            stacked: true, //make the y axis stacked
                            grid: { //change the grid color for the y axis
                                color: `${chartGridColor}`
                            },
                            ticks: { //change the font size and color of the ticks for the y axis
                                display: false
                            },
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: `${chartTicksColor}`, //change the legend color and the font size
                                font: {
                                    family: 'Lexend Deca',
                                    size: 20
                                },
                            }
                        },
                        //custom tool tip displaying status, start date and end date of the task
                        tooltip: {
                            backgroundColor: `${toolTipBgColor}`,
                            borderColor: `${toolTipBorderColor}`,
                            titleColor: `${toolTipTitleColor}`,
                            bodyColor: `${toolTipBodyColor}`,
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            titleFont: { family: 'Lexend Deca', weight: '600', size: 20 },
                            bodyFont: { family: 'Lexend Deca', size: 20 },
                            callbacks: {
                                label: ((context) => {
                                    const color = context.dataset.backgroundColor; //if the dataset is Not Started, the color will be red
                                    //get the status from the color of the dataset the bar you are hovering belongs to
                                    let status;
                                    if (color == "#DC3434") {
                                        status = "Not Started";
                                    } else if (color == "#E8762F") {
                                        status = "In Progress";
                                    } else if (color == "#00BF63") {
                                        status = "Completed";
                                    } else if (color == "#3578D5") {
                                        status = "Awaiting Validation";
                                    }

                                    //context.dataIndex][0] refers the the index of the bar so e.g. the 2nd bar down will have its data index as 1 (2-1=1 because 0 indexing)

                                    return["Status: " + status, "Start: " + context.dataset.data[context.dataIndex][0], "End: " + context.dataset.data[context.dataIndex][1]];
                                }),
                                
                            }
                        }
                    }
                }
            });
            if (forExpanded == true) {
                EG_chartObject = chartObject
            } else {
                //update the current graph chart in the currentGraphIdsAndCharts list
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        graphIdAndChart[1] = chartObject;
                    }
                }
            }
        }

        function generate_teamProductivityRate(ctx, projectId, forExpanded) {
            //getting project from project id
            let project;
            for (projectItem of employeesList) {
                if (projectItem != null) {
                    if (projectItem.id == projectId) {
                        project = projectItem;
                    }
                }
            }

            //data that helps display the graph
            let memberNames = [];

            let onTrackResults = [];
            let offTrackResults = [];
            //the graph is a stacked where for each member it displays their on track result (a green bar) and their off track result (red bar). however one of these bars is just 0
            //having a stacked bar chart allows the user to filter the graph by on/off track by clicking the graph legends
            for (member of project.employees) {
                if (member.result < 0) {
                    //if member's result is < zero, add their data to the off track results
                    offTrackResults.push(member.result);

                    onTrackResults.push(0); //we must also add 0 to the on track results
                } else {
                    //if member's result is > zero, add their data to the on track results
                    onTrackResults.push(member.result);

                    offTrackResults.push(0); //also add 0 to the off track results
                }
                memberNames.push(member.first_name + " " + member.last_name);
            }

            //colors for the graph grid and ticks depending on whether light mode or dark mode is enabled
            let chartTicksColor;
            let chartGridColor;
            let toolTipBgColor;
            let toolTipBorderColor;
            let toolTipTitleColor;
            let toolTipBodyColor;
            if (document.body.classList.contains("dark-mode")) {
                chartTicksColor = "white";
                chartGridColor = "rgba(255,255,255,0.2)";
                toolTipBgColor = '#1C2131';
                toolTipBorderColor = '#3a3f4b';
                toolTipTitleColor = '#e8ecf5';
                toolTipBodyColor = '#a0aabf';
            } else {
                chartTicksColor = "black";
                chartGridColor = "rgba(0,0,0,0.2)";
                toolTipBgColor = '#f8fafc';
                toolTipBorderColor = "black";
                toolTipTitleColor = "black";
                toolTipBodyColor = "black";
            }

            //get the current graph chart and destroy it
            if (forExpanded == false) {
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        if (graphIdAndChart[1] != null) {
                            graphIdAndChart[1].destroy();
                        }
                    }
                }
            }
            
            //the graph itself
            let chartObject = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: memberNames,
                    datasets: [
                        {
                            label: 'Off Track',
                            borderRadius: 8,
                            borderSkipped: false, // adds border radius to all sides of the bar
                            data: offTrackResults,
                            backgroundColor: "#DC3434",
                            borderWidth: 1
                        },
                        {
                            label: 'On Track',
                            borderRadius: 8,
                            borderSkipped: false,
                            data: onTrackResults,
                            backgroundColor: "#00BF63",
                            borderWidth: 1
                        }
                ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {// legend at the top to allow users to filter between ontrack / offtrack
                            labels: {
                                color: `${chartTicksColor}`, //i changed the font color and size
                                font: {
                                    family: 'Lexend Deca',
                                    size: 30
                                },
                            }
                        },
                        tooltip: {
                            backgroundColor: `${toolTipBgColor}`,
                            borderColor: `${toolTipBorderColor}`,
                            titleColor: `${toolTipTitleColor}`,
                            bodyColor: `${toolTipBodyColor}`,
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            titleFont: { family: 'Lexend Deca', weight: '600', size: 20 },
                            bodyFont: { family: 'Lexend Deca', size: 20 },
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,// display the graph title for the x axis
                                text: "Member Names",//changed the font size, set the text for the title and changed the color
                                font: {
                                    family: 'Lexend Deca',
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            ticks: { //make the ticks (little lables on the x axis) have a bigger font size and change the color of them
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the grid color for the x axis
                                color: `${chartGridColor}`
                            },
                            stacked: true, //make the graph stacked for x axis
                        },
                        y: {
                            border: {
                                display: true,
                                color: `${chartGridColor}`
                            },

                            title: {
                                display: true, // display the graph title for the y axis
                                text: "Productivity Rate %",//changed the font size, set the text for the title and changed the color
                                font: {
                                    family: 'Lexend Deca',
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the grid color for the y axis
                                color: `${chartGridColor}`
                            },
                            ticks: { //make the ticks (little lables on the y axis) have a bigger font size and change the color of them
                                font: {
                                    family: 'Lexend Deca',
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                            //make sure y axis starts at 0 and upto 50 and down to -50
                            beginAtZero: true,
                            min: -50,
                            max: 50,
                        }
                    }
                }
            });
            if (forExpanded == true) {
                EG_chartObject = chartObject
            } else {
                //update the current graph chart in the currentGraphIdsAndCharts list
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        graphIdAndChart[1] = chartObject;
                    }
                }
            }
        }

        function generate_taskStatusBars(ctx, projectId, forExpanded) {
            //getting project from project id
            let project;
            for (projectItem of employeesList) {
                if (projectItem != null) {
                    if (projectItem.id == projectId) {
                        project = projectItem;
                    }
                }
            }

            //simple bar chart so its just numbers. No arrays this time
            let NS_taskWeight = 0;
            let IP_taskWeight = 0;
            let C_taskWeight = 0;
            let AV_taskWeight = 0;

            for (task of project.tasks) {
                if (task.status == "Not Started") {
                    NS_taskWeight += getEstEffortFromSymbol(task.estimated_effort);
                } else if (task.status == "In Progress") {
                    IP_taskWeight += getEstEffortFromSymbol(task.estimated_effort);
                } else if (task.status == "Completed") {
                    C_taskWeight += getEstEffortFromSymbol(task.estimated_effort);
                } else if (task.status == "Awaiting Validation") {
                    AV_taskWeight += getEstEffortFromSymbol(task.estimated_effort);
                }
            }

            //colors for the graph grid and ticks depending on whether light mode or dark mode is enabled
            let chartTicksColor;
            let chartGridColor;
            let toolTipBgColor;
            let toolTipBorderColor;
            let toolTipTitleColor;
            let toolTipBodyColor;
            if (document.body.classList.contains("dark-mode")) {
                chartTicksColor = "white";
                chartGridColor = "rgba(255,255,255,0.2)";
                toolTipBgColor = '#1C2131';
                toolTipBorderColor = '#3a3f4b';
                toolTipTitleColor = '#e8ecf5';
                toolTipBodyColor = '#a0aabf';
            } else {
                chartTicksColor = "black";
                chartGridColor = "rgba(0,0,0,0.2)";
                toolTipBgColor = '#f8fafc';
                toolTipBorderColor = "black";
                toolTipTitleColor = "black";
                toolTipBodyColor = "black";
            }

            //get the current graph chart and destroy it
            if (forExpanded == false) {
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        if (graphIdAndChart[1] != null) {
                            graphIdAndChart[1].destroy();
                        }
                    }
                }
            }

            //the graph itself
            let chartObject = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Not Started", "In Progress", "Completed", "Awaiting Validation"],
                    datasets: [
                        {
                            label: 'Weight',
                            borderRadius: 8,
                            borderSkipped: false,
                            data: [NS_taskWeight, IP_taskWeight, C_taskWeight, AV_taskWeight],
                            backgroundColor: ["#DC3434", "#E8762F", "#00BF63", "#3578D5"],
                            borderWidth: 1
                        }
                ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { //dont display the legend because its not worth filtering by dataset for this graph
                            display: false
                        },
                        tooltip: { //change the tool tip's font sizes
                            backgroundColor: `${toolTipBgColor}`,
                            borderColor: `${toolTipBorderColor}`,
                            titleColor: `${toolTipTitleColor}`,
                            bodyColor: `${toolTipBodyColor}`,
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            titleFont: { family: 'Lexend Deca', weight: '600', size: 20 },
                            bodyFont: { family: 'Lexend Deca', size: 20 },
                        }
                    },
                    scales: {
                        x: {
                            title: { //display the title for the x axis, set the text and change the font and color
                                display: true,
                                text: "Task Status",
                                font: {
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            ticks: { //change the font size of the ticks and set the color
                                font: {
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the color of the gri dfor the x axis
                                color: `${chartGridColor}`
                            },
                            stacked: true,
                        },
                        y: {
                            border: {
                                display: true,
                                color: `${chartGridColor}`
                            },

                            title: { //display the title for the y axis and set the text and change the font size and color
                                display: true,
                                text: "Weighted Tasks",
                                font: {
                                    size: 24
                                },
                                color: `${chartTicksColor}`
                            },
                            grid: { //change the grid color for the y axis
                                color: `${chartGridColor}`
                            },
                            ticks: { //change the font size of the ticks and the color
                                font: {
                                    size: 18
                                },
                                color: `${chartTicksColor}`
                            },
                        }
                    }
                }
            });
            if (forExpanded == true) {
                EG_chartObject = chartObject
            } else {
                //update the current graph chart in the currentGraphIdsAndCharts list
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    if (graphIdAndChart[0] == project.id) {
                        graphIdAndChart[1] = chartObject;
                    }
                }
            }
        }

        function loadGraphs() {
            if (graphType != "overview") {
                for (graphIdAndChart of currentGraphIdsAndCharts) {
                    const ctx = document.getElementById(`canvas_${graphIdAndChart[0]}`);
                    if (graphType == "actualExpectedCompletions") {
                        generate_actualExpectedCompletions(ctx, graphIdAndChart[0], false);
                    } else if (graphType == "estEffortAccuracy") {
                        generate_estEffortAccuracy(ctx, graphIdAndChart[0], false, "month");
                    } else if (graphType == "ganttChart") {
                        generate_ganttChart(ctx, graphIdAndChart[0], false);
                    } else if (graphType == "teamProductivityRate") {
                        generate_teamProductivityRate(ctx, graphIdAndChart[0], false);
                    } else if (graphType == "taskStatusBars") {
                        generate_taskStatusBars(ctx, graphIdAndChart[0], false);
                    }
                }
            }
        }

        let userRole = "manager";

        function removeFromProjectsList(projectNum) {
            employeesList[parseInt(projectNum.substring(7))-1] = null;
        }

        async function loadProjectDropDownOptions() {
            await (async () => {
                //get userRole from userId
                //let userRoleObject = await getWithUrl(`/part-3-team-06/api/get_employee_role_type.php?employee_id=${userId}`);
                //userRole = userRoleObject.role_type;

                let buttons = "";
                for (graph of graphTypesList) {
                    if (graph == "overview") {
                        buttons += `
                            <button id="overview_button" onclick="updateGraphType('overview')" class="activeButton textColor" style="white-space: nowrap; border: none; font-size: 24px; padding: 2px 10px 2px; border-radius: 100px; width: fit-content">
                                Overview
                            </button>
                        `;
                    } else if (graph == "actualExpectedCompletions") {
                        buttons += `
                            <button id="actualExpectedCompletions_button" onclick="updateGraphType('actualExpectedCompletions')" class="secondaryBackground textColor" style="white-space: nowrap; border: none; font-size: 24px; padding: 2px 10px 2px; border-radius: 100px; width: fit-content">
                                Actual / Expected Completions
                            </button>
                        `;
                    } else if (graph == "estEffortAccuracy") {
                        buttons += `
                            <button id="estEffortAccuracy_button" onclick="updateGraphType('estEffortAccuracy')" class="secondaryBackground textColor" style="white-space: nowrap; border: none; font-size: 24px; padding: 2px 10px 2px; border-radius: 100px; width: fit-content">
                                Effort Estimation Accuracy
                            </button>
                        `;
                    } else if (graph == "ganttChart") {
                        buttons += `
                            <button id="ganttChart_button" onclick="updateGraphType('ganttChart')" class="secondaryBackground textColor" style="white-space: nowrap; border: none; font-size: 24px; padding: 2px 10px 2px; border-radius: 100px; width: fit-content">
                                Gantt Chart
                            </button>
                        `;
                    } else if (graph == "teamProductivityRate") {
                        buttons += `
                            <button id="teamProductivityRate_button" onclick="updateGraphType('teamProductivityRate')" class="secondaryBackground textColor" style="white-space: nowrap; border: none; font-size: 24px; padding: 2px 10px 2px; border-radius: 100px; width: fit-content">
                                Team Productivity Rate
                            </button>
                        `;
                    } else if (graph == "taskStatusBars") {
                        buttons += `
                            <button id="taskStatusBars_button" onclick="updateGraphType('taskStatusBars')" class="secondaryBackground textColor" style="white-space: nowrap; border: none; font-size: 24px; padding: 2px 10px 2px; border-radius: 100px; width: fit-content">
                                Task Status Bars
                            </button>
                        `;
                    }
                }
                document.getElementById("rowOfButtons").innerHTML = buttons;
                
                const allProjectsListObject = await getWithUrl(`/part-3-team-06/api/get_employee_projects.php?employee_id=${userId}`);
                const allProjectsList = allProjectsListObject.projects;

                let dropDownOptions = "";
                dropDownOptions += `<li onclick="projectDropDownUpdate('None', -1)"><a class="dropdown-item fadedTextColor" style="font-size: 22px;">None</a></li>`;
                for (project of allProjectsList) {
                    dropDownOptions += `<li onclick="projectDropDownUpdate('${project.name}', ${project.project_id})"><a class="dropdown-item textColor" style="font-size: 22px;">${project.name}</a></li>`;
                }
                document.getElementById("projectDropDownOptions").innerHTML = dropDownOptions;

                if (allProjectsList.length > 0) {
                    let randomProject = allProjectsList[Math.floor(Math.random() * allProjectsList.length)];
                    await projectDropDownUpdate(randomProject.name, randomProject.project_id);

                    const teamMembersDataObject = await getWithUrl(`/part-3-team-06/api/get_all_employees_by_project.php?project_id=${randomProject.project_id}`);
                    const teamMembersList = teamMembersDataObject.employees;
                    
                    for (let i = 1; i <= 4; i++) {
                        if (teamMembersList.length > 0) {
                            let randomMember = teamMembersList[Math.floor(Math.random() * teamMembersList.length)];
                            
                            await projectsDropDownUpdate(`project${i}`, `${randomMember.first_name + " " + randomMember.last_name}`, randomMember.employee_id, randomProject.project_id);
                        }
                    }

                }
            })();
        }

        function clearEmployeeDropDownOptions() {
            for (let i = 1; i <= 4; i++) {
                document.getElementById(`project${i}`).innerHTML = `<span class="fadedTextColor">None</span>`;
                let dropDown = document.getElementById(`project${i}_dropDown`);
                dropDown.innerHTML = "";
            }
            employeesList = [null, null, null, null];
            sortProjectsDropDownUpdate(document.getElementById("sortProjectsDropDownButton").textContent);
            loadProjectSections();
        }

        async function loadEmployeeDropDownOptions(selectedProjectId) {
            await (async () => {
                const teamMembersDataObject = await getWithUrl(`/part-3-team-06/api/get_all_employees_by_project.php?project_id=${selectedProjectId}`);
                const teamMembersList = teamMembersDataObject.employees;

                for (let i = 1; i <= 4; i++) {
                    let dropDownOptions = "";
                    dropDownOptions += `<li onclick="projectsDropDownUpdate('project${i}', 'None', -1, ${selectedProjectId})"><a class="dropdown-item fadedTextColor" style="font-size: 22px;">None</a></li>`;
                    for (member of teamMembersList) {
                        dropDownOptions += `<li onclick="projectsDropDownUpdate('project${i}', '${member.first_name + " " + member.last_name}', ${member.employee_id}, ${selectedProjectId})"><a class="dropdown-item textColor" style="font-size: 22px;">${member.first_name + " " + member.last_name}</a></li>`;
                    }
                    document.getElementById(`project${i}_dropDown`).innerHTML = dropDownOptions;
                }
            })();
        }

        async function addToProjectsList(projectNum, projectId, projectTitle, globalProjectId) {
            await (async () => {
                //see if a project with the same project id already exists
                let duplicateEmployeeId
                for (employee of employeesList){
                    if (employee != null) {
                        if (employee.id.split("_")[0] == projectId) {
                            duplicateEmployeeId = employee.id;
                        }
                    }
                }

                let formattedEmployeeId = projectNum + "_" + projectId;

                if (duplicateEmployeeId) {
                    if (duplicateEmployeeId.split("_").length > 1) {
                        formattedEmployeeId = projectId + "_" + (parseInt(duplicateEmployeeId.split("_")[1]) + 1);
                    } else {
                        formattedEmployeeId = projectId + "_2";
                    }
                } else {
                    formattedEmployeeId = projectId.toString();
                }

                //now get the start and end date
                let projectInfo = await getWithUrl(`/part-3-team-06/api/get_project_details.php?project_id=${globalProjectId}`);

                //now get the tasks for the project
                let tasksDataObject;

                tasksDataObject = await getWithUrl(`/part-3-team-06/api/get_project_gantt_chart_data.php?project_id=${globalProjectId}&employee_id=${projectId}`);
                const tasksList = tasksDataObject.tasks;

                //now get the employee result for the project
                let teamMemberResultObject = await getWithUrl(`/part-3-team-06/api/get_employee_project_progress.php?employee_id=${userId}&project_id=${globalProjectId}`);
                const teamMemberResult = teamMemberResultObject.result;

                let EEA_tasksDataObject;

                EEA_tasksDataObject = await getWithUrl(`/part-3-team-06/api/get_project_effort_estimation_accuracy.php?project_id=${globalProjectId}&employee_id=${projectId}`);
                const EEA_tasksList = EEA_tasksDataObject.tasks;

                let tasksDone = 0;
                let tasksLeft = 0;
                for (task of tasksList) {
                    if (task.status == "Completed") {
                        tasksDone += 1;
                    } else {
                        tasksLeft += 1;
                    }
                }

                const progress = (tasksDone / (tasksDone + tasksLeft)).toFixed(2) * 100 + "%";

                employeesList[parseInt(projectNum.substring(7))-1] = {id: formattedEmployeeId, title: projectTitle, tasks: tasksList, employeeResult: teamMemberResult, start_date: projectInfo.start_date, due_date: projectInfo.due_date, EEA_tasks: EEA_tasksList, tasksDone: tasksDone, tasksLeft: tasksLeft, progress: progress};
            })();
        }

        let employeesList = [null, null, null, null];
        let graphType = "overview";

        //function  to close the popup
        function closePopup(event) {
            let infoContent = event.target.firstElementChild;

            infoContent.style.pointerEvents = "none";
            infoContent.style.opacity = 0;
            setTimeout(() => {
                if (infoContent.style.opacity == 0) {
                    infoContent.style.display = "none";
                }
            }, 400);

        }

        //function to display the popup and then adjust the position and size of the popup
        function displayPopupAndAdjust(event) {
            //display the popup
            let infoContent = event.target.firstElementChild;

            infoContent.style.pointerEvents = "all";
            infoContent.style.display = "block";
            setTimeout(() => {
                infoContent.style.opacity = 1;
            }, 0);

            //calculate width and adjust position
            let infoIconPosition = event.target.getBoundingClientRect().x;
            let windowWidth = document.documentElement.clientWidth;

            //get the default width depending on the first line of the popup contents
            let popUpFirstLine = infoContent.firstElementChild.textContent;
            if (popUpFirstLine == "Tasks Info") {
                defaultWidth = "520px";
            } else {
                defaultWidth = "900px";
            }

            //new width used for the code underneath the code directly below this
            let newWidth;

            //if the window width is < than default width update the popup width to the window width. also update the newWidth variable
            if (windowWidth < parseInt(defaultWidth)) {
                infoContent.style.width = windowWidth + "px";
                newWidth = windowWidth;
            } else {
                infoContent.style.width = defaultWidth;
                newWidth = defaultWidth;
            }

            let leftPosition; //by default the popup.left attribute is 0 and the left side of the pop up is parallel with the left side of the info icon. the code below adjust this variable and we position the popup relative to the infoIcon
            
            let infoIconWidth = event.target.getBoundingClientRect().width;
            let neededLeftSpace = (parseInt(newWidth) - parseInt(infoIconWidth)) / 2;
            //current position also is the number of pixels from the side of the screen to the info icon
            //if the space from side to the info icon is < than the needed space we set the leftPosition variable to the negative of the space on the left
            if (infoIconPosition > neededLeftSpace) {
                leftPosition = -neededLeftSpace;
            } else {
                leftPosition = -parseInt(infoIconPosition);
            }

            //after adjusting the leftPosition based on the left space of the popup we adjust the leftPosition based on the space on the right if necessary
            let actualRightSpace = windowWidth - (parseInt(infoIconPosition) + infoIconWidth);
            let neededRightSpace = neededLeftSpace;
            if (actualRightSpace < neededRightSpace) {
                leftPosition -= (neededRightSpace - actualRightSpace);
            }

            infoContent.style.left = leftPosition + "px";
        }

        function displayPopup(event) {
            let infoContent = event.target;

            infoContent.style.pointerEvents = "all";
            infoContent.style.opacity = 1;
            setTimeout(() => {
                infoContent.style.display = "block";
            }, 0);
            infoContent.style
        }

        function loadProjectSections() {
            const projectSectionsGrid = document.getElementById("projectSectionsGrid");
            projectSectionsGrid.innerHTML = "";
            currentGraphIdsAndCharts = [];

            for (project of sortedProjectsList) {
                if (project != null) {
                    if (graphType == "overview") {
                        const projectTitle = project.title;
                        const projectTasksList = project.tasks;

                        let tasksDone = project.tasksDone;
                        let xl_tasksDone = 0;
                        let l_tasksDone = 0;
                        let m_tasksDone = 0;
                        let s_tasksDone = 0;
                        let xs_tasksDone = 0;

                        let tasksLeft = project.tasksLeft;
                        let xl_tasksLeft = 0;
                        let l_tasksLeft = 0;
                        let m_tasksLeft = 0;
                        let s_tasksLeft = 0;
                        let xs_tasksLeft = 0;

                        for (task of projectTasksList) {

                            if (task.status == "Completed") {
                                if (task.estimated_effort == "XL") {
                                    xl_tasksDone += 1;
                                } else if (task.estimated_effort == "L") {
                                    l_tasksDone += 1;
                                } else if (task.estimated_effort == "M") {
                                    m_tasksDone += 1;
                                } else if (task.estimated_effort == "S") {
                                    s_tasksDone += 1;
                                } else {
                                    xs_tasksDone += 1;
                                }

                            } else {
                                if (task.estimated_effort == "XL") {
                                    xl_tasksLeft += 1;
                                } else if (task.estimated_effort == "L") {
                                    l_tasksLeft += 1;
                                } else if (task.estimated_effort == "M") {
                                    m_tasksLeft += 1;
                                } else if (task.estimated_effort == "S") {
                                    s_tasksLeft += 1;
                                } else {
                                    xs_tasksLeft += 1;
                                }
                            }
                        }

                        const progress = project.progress;
                        
                        let projectOnOffTrackResult = project.employeeResult;

                        let redOrGreen;
                        if (projectOnOffTrackResult < 0) {
                            redOrGreen = "#DC3434";
                        } else {
                            redOrGreen = "#00BF63";
                        }

                        let tasksDoneAvg = 0;
                        let tasksLeftAvg = 0;
                        let totalProjCount = 0;
                        //calculate average tasks done / left amongst all the compared projects
                        for (project of employeesList) {
                            if (project != null) {
                                totalProjCount += 1;
                                for (task of project.tasks) {
                                    if (task.status == "Completed") {
                                        tasksDoneAvg += 1;
                                    } else {
                                        tasksLeftAvg += 1;
                                    }
                                }
                            }
                        }

                        //get the average by dividing by totalProjCount
                        if (totalProjCount != 0) {
                            tasksDoneAvg = tasksDoneAvg / totalProjCount;
                            tasksLeftAvg = tasksLeftAvg / totalProjCount;
                        }

                        let done_avgDifference;
                        if (tasksDone == 0) {
                            done_avgDifference = (-tasksDoneAvg).toFixed(2);
                        } else if (tasksDoneAvg == 0) {
                            done_avgDifference = tasksDone.toFixed(2);
                        } else {
                            done_avgDifference = ((tasksDone - tasksDoneAvg) / tasksDoneAvg).toFixed(2);
                        }

                        const done_avgDifferenceFormatted = Math.abs(done_avgDifference) * 100 + "%";

                        let done_avgGreenOrRed;
                        let done_avgDifferenceExplanation;

                        if (done_avgDifference < 0) {
                            done_avgGreenOrRed = "#DC3434";
                            done_avgDifferenceExplanation = "Less";
                            done_avgUpOrDown = `<i class="bi bi-chevron-down" style="font-size: 40px;"></i>`;
                        } else {
                            done_avgGreenOrRed = "#00BF63";
                            done_avgDifferenceExplanation = "More";
                            done_avgUpOrDown = `<i class="bi bi-chevron-up" style="font-size: 40px;"></i>`;
                        }


                        let left_avgDifference;
                        if (tasksLeft == 0) {
                            left_avgDifference = (-tasksLeftAvg).toFixed(2);
                        } else if (tasksLeftAvg == 0) {
                            left_avgDifference = tasksLeft.toFixed(2);
                        } else {
                            left_avgDifference = ((tasksLeft - tasksLeftAvg) / tasksLeftAvg).toFixed(2);
                        }

                        const left_avgDifferenceFormatted = Math.abs(left_avgDifference) * 100 + "%";

                        let left_avgGreenOrRed;
                        let left_avgDifferenceExplanation;
                        
                        if (left_avgDifference < 0) {
                            left_avgGreenOrRed = "#DC3434";
                            left_avgDifferenceExplanation = "More";
                            left_avgUpOrDown = `<i class="bi bi-chevron-up" style="font-size: 40px;"></i>`;
                        } else {
                            left_avgGreenOrRed = "#00BF63";
                            left_avgDifferenceExplanation = "Less";
                            left_avgUpOrDown = `<i class="bi bi-chevron-down" style="font-size: 40px;"></i>`;
                        }


                        const overviewCard = `
                            <div class="secondaryBackground graphSectionBackground">
                                <!--title and progress bar-->
                                <div class="unFlexForMediumSizedScreen primaryBackground" style="border-radius: 20px; padding: 5px 20px 5px; display: flex; place-items: center;">
                                    <p style="font-size: 36px; margin: 0; white-space: pre;">${projectTitle}</p>
                                    <div style="width: 30px;"></div>

                                    <div class="progress secondaryBackground" role="progressbar" style="border-radius: 100px; height: 25px; width: 100%;">
                                        <div id="projectProgressBar" class="progress-bar" style="width: ${progress}; border-radius: 100px; font-size: 18px; background-color: ${redOrGreen}">${progress}</div>
                                    </div>
                                </div>

                                <div style="height: 15px;"></div>

                                <!--graph container and graph title-->
                                <div class="primaryBackground" style="border-radius: 20px; padding: 5px 20px 15px 20px; display: flex;">
                                    <div style="width: 100%">
                                        <p style="font-size: 42px; margin: 0;">Overview</p>
                                        <p style="font-size: 26px; margin: 0;">${tasksDone}/${tasksDone + tasksLeft} TASKS DONE</p>

                                        <div style="height: 10px;"></div>
                                        
                                        <div style="width: 100%">
                                            <div class="unFlexForOverview" style="display: flex; width: 100%">
                                                <div class="fillScreenForSmallScreen unFlexForOverview secondaryBackground" style="display: flex; place-items: center; justify-content: space-between; border-radius: 20px; padding: 10px;">
                                                    <p style="font-size: 26px; margin: 0;">TASKS DONE: <span style="color: #00BF63;">${tasksDone}</span></p>
                                                    
                                                    <div style="display: flex; gap: 20px;">
                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">XL</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #00BF63;">${xl_tasksDone}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">L</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #00BF63;">${l_tasksDone}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">M</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #00BF63;">${m_tasksDone}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">S</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #00BF63;">${s_tasksDone}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">XS</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #00BF63;">${xs_tasksDone}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="width: 10px"></div>

                                                <div style="display: flex; place-items: center">
                                                    ${done_avgUpOrDown}
                                                    <div style="width: 10px;"></div>
                                                    <div>
                                                        <p style="font-size: 28px; margin: 0; color: ${done_avgGreenOrRed}">${done_avgDifferenceFormatted + " " + done_avgDifferenceExplanation}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="height: 20px;"></div>

                                            <div class="unFlexForOverview" style="display:flex; width: 100%">
                                                <div class="fillScreenForSmallScreen unFlexForOverview secondaryBackground" style="display: flex; place-items: center; justify-content: space-between; border-radius: 20px; padding: 10px;">
                                                    <p style="font-size: 26px; margin: 0;">TASKS LEFT: <span style="color: #DC3434;">${tasksLeft}</span></p>
                                                    
                                                    <div style="display: flex; gap: 20px;">
                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">XL</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #DC3434;">${xl_tasksLeft}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">L</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #DC3434;">${l_tasksLeft}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">M</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #DC3434;">${m_tasksLeft}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">S</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #DC3434;">${s_tasksLeft}</div>
                                                        </div>

                                                        <div style="place-items: center;">
                                                            <p style="font-size: 26px; margin: 0; font-weight: bold;">XS</p>
                                                            <div class="primaryBackground" style="border-radius: 100%; text-align: center; height: 40px; width: 40px; line-height: 40px; font-size: 26px; color: #DC3434;">${xs_tasksLeft}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="width: 10px"></div>

                                                <div style="display: flex; place-items: center;">
                                                    ${left_avgUpOrDown}
                                                    <div style="width: 10px;"></div>
                                                    <div>
                                                        <p style="font-size: 28px; margin: 0; color: ${left_avgGreenOrRed};">${left_avgDifferenceFormatted + " " + left_avgDifferenceExplanation}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="removeForSmallScreen fadedTextColor" style="font-size: 22px; margin: 0; font-style: italic; float: right; width: 50%; text-align: right;">(Compared to the average of the compared employees.)</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        projectSectionsGrid.innerHTML += overviewCard;
                    } else {
                        const projectTasksList = project.tasks;

                        let tasksDone = 0;
                        let tasksLeft = 0;

                        for (task of projectTasksList) {
                            if (task.status == "Completed") {
                                tasksDone += 1;
                            } else {
                                tasksLeft += 1;
                            }
                        }

                        const progress = (tasksDone / (tasksDone + tasksLeft)).toFixed(2) * 100 + "%";
                        
                        let projectOnOffTrackResult = project.employeeResult;

                        let redOrGreen;
                        if (projectOnOffTrackResult < 0) {
                            redOrGreen = "#DC3434";
                        } else {
                            redOrGreen = "#00BF63";
                        }

                        let graphTitle;
                        let infoText;

                        if (graphType == "actualExpectedCompletions") {
                            graphTitle = "Actual / Expected Completions";

                            infoText = `
                                <p style="font-size: 40px; margin: 0; text-decoration: underline">Actual / Expected Completions Info</p>
                                <div style="height: 5px;"></div>
                                <p style="font-size: 24px; margin: 0; font-weight: bold">• This graph shows the expected completion dates and the actual completion dates for each task.</p>
                                <p style="font-size: 24px; margin: 0;">• The start of the x axis is the start date of the project.</p>
                            `;
                        } else if (graphType == "estEffortAccuracy") {
                            graphTitle = "Effort Estimation Accuracy";

                            infoText = `
                                <p style="font-size: 40px; margin: 0; text-decoration: underline">Effort Estimation Accuracy Info</p>
                                <div style="height: 5px;"></div>
                                <p style="font-size: 24px; margin: 0; font-weight: bold">• This graph is designed to give an idea of how accurate the estimated effort assigned to a task was.</p>
                                <div style="height: 5px;"></div>
                                <p style="font-size: 24px; margin: 0; font-weight: bold">• For each completed task, you can see the ratio of actual hours to estimated hours the task has taken.</p>
                                <div style="height: 10px;"></div>
                                <p style="font-size: 24px; margin: 0;">• <span style="color: #00BF63">If a task's ratio is < 1</span>, the task took less effort than required (under estimate - the bar for it is green)</p>
                                <div style="height: 10px;"></div>
                                <p style="font-size: 24px; margin: 0;">• <span style="color: #E8762F">If a task's ratio is between 1 and 1.5</span>, the task took more effort than required (over estimate - the bar for it is orange)</p>
                                <div style="height: 10px;"></div>
                                <p style="font-size: 24px; margin: 0;">• <span style="color: #DC3434">If a task's ratio is > 1.5</span>, the task took disproportionately more effort than required (severely over estimated - the bar for it is red)</p>
                            `;
                        } else if (graphType == "ganttChart") {
                            graphTitle = "Gantt Chart";

                            infoText = `
                                <p style="font-size: 40px; margin: 0; text-decoration: underline">Gantt Chart Info</p>
                                <div style="height: 5px;"></div>
                                <p style="font-size: 24px; margin: 0; font-weight: bold">• This graph shows each task in the project sorted from earliest start to latest start.</p>
                                <p style="font-size: 24px; margin: 0;">• The start of the x axis is the start date of the project.</p>
                                <p style="font-size: 24px; margin: 0;">• For each task, you can view its status, start date and end date.</p>
                            `;
                        } else if (graphType == "teamProductivityRate") {
                            graphTitle = "Team Productivity Rate";

                            infoText = `
                                <p style="font-size: 40px; margin: 0; text-decoration: underline">Team Productivity Rate Info</p>
                                <div style="height: 5px;"></div>
                                <p style="font-size: 24px; margin: 0; font-weight: bold">• This graph shows each member's productivity rate: a positive / negative percentage indicating how on / off track the employee is.</p>
                                <p></p>
                                <p style="font-size: 24px; margin: 0;">• A team member may be off track because they have less completed tasks compared to the projects duration and their total assigned tasks.</p>
                                <p></p>
                                <p style="font-size: 30px; margin: 0; font-weight: bold;">Formula for each employee:</p>
                                <p style="font-size: 24px; margin: 0; font-weight: bold;">Where</p>
                                <p style="font-size: 24px; margin: 0;">• NET = Number of Employee Tasks <span class="fadedTextColor" style="font-style: italic; font-weight: normal;">(weighted)</span></p>
                                <p style="font-size: 24px; margin: 0;">• NPT = Number of Project Tasks <span class="fadedTextColor" style="font-style: italic; font-weight: normal;">(weighted)</span></p>
                                <p style="font-size: 24px; margin: 0;">• PD = Duration of the project</p>
                                <div style="display: flex; text-align: center; place-items: center;">
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">(</p>
                                    <div>
                                        <p style="font-size: 24px; margin: 0;">NET<sub>Completed</sub></p>
                                        <div class="contrastingThemeColor" style="width: 100%; height: 3px; margin: 10px 0 10px;"></div>
                                        <p style="font-size: 24px; margin: 0;">NPT<sub>Total</sub></p>
                                    </div>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">)</p>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">-</p>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">(</p>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">(</p>
                                    <div>
                                        <p style="font-size: 24px; margin: 0;">PD<sub>Elapsed</sub></p>
                                        <div class="contrastingThemeColor" style="width: 100%; height: 3px; margin: 10px 0 10px;"></div>
                                        <p style="font-size: 24px; margin: 0;">PD<sub>Total</sub></p>
                                    </div>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">)</p>
                                    <p style="font-size: 60px; margin-bottom: 30px; font-weight: 100">x</p>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">(</p>
                                    <div>
                                        <p style="font-size: 24px; margin: 0;">NET<sub>Total</sub></p>
                                        <div class="contrastingThemeColor" style="width: 100%; height: 3px; margin: 10px 0 10px;"></div>
                                        <p style="font-size: 24px; margin: 0;">NPT<sub>Total</sub></p>
                                    </div>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">)</p>
                                    <p style="font-size: 100px; margin-bottom: 30px; font-weight: 100">)</p>
                                </div>
                            `;
                        } else if (graphType == "taskStatusBars") {
                            graphTitle = "Task Status Bars";

                            infoText = `
                                <p style="font-size: 40px; margin: 0; text-decoration: underline">Task Status Bars Info</p>
                                <div style="height: 5px;"></div>
                                <p style="font-size: 24px; margin: 0; font-weight: bold">• This graph shows how many tasks <span style="font-style: italic;">(weighted)</span> belongs to each type of task status.</p>
                            `;
                        }

                        let graphWidth;
                        if (graphType == "teamProductivityRate") {
                            const maxMemberCountBeforeScroll = 5;
                            if (project.employees.length > maxMemberCountBeforeScroll) {
                                const newWidth = (project.employees.length / maxMemberCountBeforeScroll) * 100
                                graphWidth = newWidth + "%";
                            } else {
                                graphWidth = "100%";
                            }
                        } else {
                            graphWidth = "100%";
                        }

                        let graphHeight;
                        if (graphType == "ganttChart") {
                            const maxNumberOfTasksBeforeScroll = 3;
                            if (projectTasksList.length > maxNumberOfTasksBeforeScroll) {
                                const newHeight = (projectTasksList.length / maxNumberOfTasksBeforeScroll) * 100
                                graphHeight = newHeight + "%";
                            } else {
                                graphHeight = "100%";
                            }
                        } else {
                            graphHeight = "100%";
                        }

                        const graphCard = `
                            <div class="secondaryBackground graphSectionBackground">
                                <!--title and progress bar-->
                                <div class="unFlexForMediumSizedScreen primaryBackground" style="border-radius: 20px; padding: 5px 20px 5px; display: flex; place-items: center;">
                                    <p style="font-size: 36px; margin: 0; white-space: pre;">${project.title}</p>
                                    <div style="width: 30px;"></div>

                                    <div class="progress secondaryBackground" role="progressbar" style="border-radius: 100px; height: 25px; width: 100%;">
                                        <div id="projectProgressBar" class="progress-bar" style="width: ${progress}; border-radius: 100px; font-size: 18px; background-color: ${redOrGreen}">${progress}</div>
                                    </div>
                                </div>

                                <div style="height: 15px;"></div>

                                <!--graph container and graph title-->
                                <div class="primaryBackground" style="display: flex; flex-direction: column; border-radius: 20px; padding: 0px 30px 30px 30px;">
                                    <div class="unFlexForSmallScreen" style="display: flex; justify-content: space-between; place-items: center">
                                        <p style="font-size: 36px; margin: 0; padding: 5px 0px 5px;">
                                            ${graphTitle}
                                            <button onmouseenter="displayPopupAndAdjust(event)" onmouseleave="closePopup(event)" class="infoIcon">i
                                                <div onmouseenter="displayPopup(event)" class="secondaryBackground textColor infoPopup">
                                                    ${infoText}
                                                </div>
                                            </button>   
                                        </p>
                                        <div>
                                            <button onclick="expandGraph('${project.id}')" class="secondaryBackground expandGraphButton textColor">
                                                <i class="bi bi-arrows-fullscreen"></i>
                                                <div style="width: 10px"></div>
                                                <p style="white-space: pre; margin: 0">Expand Graph</p>
                                            </button>
                                            <div class="showForSmallScreen" style="height: 10px"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="secondaryBackground" style="flex: 1; border-radius: 20px; padding: 10px; overflow: auto; height: 390px;">
                                            <div style="height: ${graphHeight}; width: ${graphWidth}">
                                                <canvas id="canvas_${project.id}"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        projectSectionsGrid.innerHTML += graphCard;
                        currentGraphIdsAndCharts.push([project.id, null]);
                    }
                }
            }
            loadGraphs();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
</body>


</html>