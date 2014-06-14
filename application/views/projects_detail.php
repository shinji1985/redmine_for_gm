
</div>
  <div class="robicchigantt">
            <div id="workSpace" style="padding:0px; overflow-y:auto; overflow-x:hidden;border:1px solid #e5e5e5;position:relative;margin:0 5px"></div>

            <div id="taZone" style="display:none;" class="noprint">
                <textarea rows="8" cols="150" id="ta">
    {"tasks":[
    {"id":-1,"name":"Gantt editor","code":"","level":0,"status":"STATUS_ACTIVE","canWrite":true,"start":1396994400000,"duration":21,"end":1399672799999,"startIsMilestone":true,"endIsMilestone":false,"collapsed":false,"assigs":[],"hasChild":true}
    ,{"id":-2,"name":"coding","code":"","level":1,"status":"STATUS_ACTIVE","canWrite":true,"start":1396994400000,"duration":10,"end":1398203999999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"description":"","progress":0,"hasChild":true}
    ,{"id":-3,"name":"gant part","code":"","level":2,"status":"STATUS_ACTIVE","canWrite":true,"start":1396994400000,"duration":2,"end":1397167199999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"depends":"","hasChild":false}
    ,{"id":-4,"name":"editor part","code":"","level":2,"status":"STATUS_SUSPENDED","canWrite":true,"start":1397167200000,"duration":4,"end":1397685599999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"depends":"3","hasChild":false}
    ,{"id":-5,"name":"testing","code":"","level":1,"status":"STATUS_SUSPENDED","canWrite":true,"start":1398981600000,"duration":6,"end":1399672799999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"depends":"2:5","description":"","progress":0,"hasChild":true}
    ,{"id":-6,"name":"test on safari","code":"","level":2,"status":"STATUS_SUSPENDED","canWrite":true,"start":1398981600000,"duration":2,"end":1399327199999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"depends":"","hasChild":false}
    ,{"id":-7,"name":"test on ie","code":"","level":2,"status":"STATUS_SUSPENDED","canWrite":true,"start":1399327200000,"duration":3,"end":1399586399999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"depends":"6","hasChild":false}
    ,{"id":-8,"name":"test on chrome","code":"","level":2,"status":"STATUS_SUSPENDED","canWrite":true,"start":1399327200000,"duration":2,"end":1399499999999,"startIsMilestone":false,"endIsMilestone":false,"collapsed":false,"assigs":[],"depends":"6","hasChild":false}
    ],"selectedRow":0,"canWrite":true,"canWriteOnParent":true}  </textarea>

                <button onclick="loadGanttFromServer();">load</button>
            </div>

            <style>
                .resEdit {
                    padding: 15px;
                }

                .resLine {
                    width: 95%;
                    padding: 3px;
                    margin: 5px;
                    border: 1px solid #d0d0d0;
                }

                body {
                    overflow: hidden;
                }

                .ganttButtonBar h1{
                    color: #000000;
                    font-weight: bold;
                    font-size: 28px;
                    margin-left: 10px;
                }

            </style>

            <form id="gimmeBack" style="display:none;" action="../gimmeBack.jsp" method="post" target="_blank"><input type="hidden" name="prj" id="gimBaPrj"></form>

            <script type="text/javascript">

                var ge;  //this is the hugly but very friendly global var for the gantt editor
                $(function() {

                    //load templates
                    $("#ganttemplates").loadTemplates();

                    // here starts gantt initialization
                    ge = new GanttMaster();
                    var workSpace = $("#workSpace");
                    workSpace.css({width:$(window).width() - 20,height:$(window).height() - 100});
                    ge.init(workSpace);

                    //inject some buttons (for this demo only)
                    $(".ganttButtonBar div").append("<button onclick='clearGantt();' class='btn btn-default'>clear</button>")
                    .append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
                    .append("<button onclick='openResourceEditor();' class='btn btn-default' style='margin-right:5px;'>edit resources</button>")
                    .append("<a target='_blank' href='<?= REDMINE_URL; ?>projects/<?= $project['identifier']; ?>' class='btn btn-default' style='margin-right:5px; color:#333; text-decoration:none; font-weight:normal;'>Redmine</a>")
                    .append("<button onclick='getFile();' class='btn btn-default'>export</button>");
                    //  $(".ganttButtonBar h1").html("Twproject<br>jQuery Gantt");
                    //                    $(".ganttButtonBar h1").html("<a href='http://twproject.com' title='Twproject the friendly project and work management tool' target='_blank'><img width='80%' src='twBanner.jpg'></a>");
                    $(".ganttButtonBar div").addClass('buttons');
                    //overwrite with localized ones
                    loadI18n();

                    //simulate a data load from a server.
                    loadGanttFromServer();


                    //fill default Teamwork roles if any
                    if (!ge.roles || ge.roles.length == 0) {
                        setRoles();
                    }

                    //fill default Resources roles if any
                    if (!ge.resources || ge.resources.length == 0) {
                        setResource();
                    }


                    /*/debug time scale
              $(".splitBox2").mousemove(function(e){
                var x=e.clientX-$(this).offset().left;
                var mill=Math.round(x/(ge.gantt.fx) + ge.gantt.startMillis)
                $("#ndo").html(x+" "+new Date(mill))
              });*/


                    $(window).resize(function(){
                        workSpace.css({width:$(window).width() - 20,height:$(window).height() - 100});
                        workSpace.trigger("resize.gantt");
                    })

                });


                function loadGanttFromServer(taskId, callback) {

                    //this is a simulation: load data from the local storage if you have already played with the demo or a textarea with starting demo data
                    loadFromLocalStorage();

                    //this is the real implementation
                    /*
              //var taskId = $("#taskSelector").val();
              var prof = new Profiler("loadServerSide");
              prof.reset();

              $.getJSON("ganttAjaxController.jsp", {CM:"LOADPROJECT",taskId:taskId}, function(response) {
                //console.debug(response);
                if (response.ok) {
                  prof.stop();

                  ge.loadProject(response.project);
                  ge.checkpoint(); //empty the undo stack

                  if (typeof(callback)=="function") {
                    callback(response);
                  }
                } else {
                  jsonErrorHandling(response);
                }
              });
                     */
                }


                function saveGanttOnServer() {
                    if(!ge.canWrite)
                        return;


                    //this is a simulation: save data to the local storage or to the textarea
                    saveInLocalStorage();


                    /*
              var prj = ge.saveProject();

              delete prj.resources;
              delete prj.roles;

              var prof = new Profiler("saveServerSide");
              prof.reset();

              if (ge.deletedTaskIds.length>0) {
                if (!confirm("TASK_THAT_WILL_BE_REMOVED\n"+ge.deletedTaskIds.length)) {
                  return;
                }
              }

              $.ajax("ganttAjaxController.jsp", {
                dataType:"json",
                data: {CM:"SVPROJECT",prj:JSON.stringify(prj)},
                type:"POST",

                success: function(response) {
                  if (response.ok) {
                    prof.stop();
                    if (response.project) {
                      ge.loadProject(response.project); //must reload as "tmp_" ids are now the good ones
                    } else {
                      ge.reset();
                    }
                  } else {
                    var errMsg="Errors saving project\n";
                    if (response.message) {
                      errMsg=errMsg+response.message+"\n";
                    }

                    if (response.errorMessages.length) {
                      errMsg += response.errorMessages.join("\n");
                    }

                    alert(errMsg);
                  }
                }

              });
                     */
                }


                //-------------------------------------------  Create some demo data ------------------------------------------------------
                function setRoles() {
                    ge.roles = [
                        {
                            id:"tmp_1",
                            name:"Project Manager"
                        },
                        {
                            id:"tmp_2",
                            name:"Worker"
                        },
                        {
                            id:"tmp_3",
                            name:"Stakeholder/Customer"
                        }
                    ];
                }

                function setResource() {
                    var res = [];
                    for (var i = 1; i <= 10; i++) {
                        res.push({id:"tmp_" + i,name:"Resource " + i});
                    }
                    ge.resources = res;
                }


                function clearGantt() {
                    ge.reset();
                }

                function loadI18n() {
                    GanttMaster.messages = {
                        "CANNOT_WRITE":                  "CANNOT_WRITE",
                        "CHANGE_OUT_OF_SCOPE":"NO_RIGHTS_FOR_UPDATE_PARENTS_OUT_OF_EDITOR_SCOPE",
                        "START_IS_MILESTONE":"START_IS_MILESTONE",
                        "END_IS_MILESTONE":"END_IS_MILESTONE",
                        "TASK_HAS_CONSTRAINTS":"TASK_HAS_CONSTRAINTS",
                        "GANTT_ERROR_DEPENDS_ON_OPEN_TASK":"GANTT_ERROR_DEPENDS_ON_OPEN_TASK",
                        "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK":"GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK",
                        "TASK_HAS_EXTERNAL_DEPS":"TASK_HAS_EXTERNAL_DEPS",
                        "GANTT_ERROR_LOADING_DATA_TASK_REMOVED":"GANTT_ERROR_LOADING_DATA_TASK_REMOVED",
                        "ERROR_SETTING_DATES":"ERROR_SETTING_DATES",
                        "CIRCULAR_REFERENCE":"CIRCULAR_REFERENCE",
                        "CANNOT_DEPENDS_ON_ANCESTORS":"CANNOT_DEPENDS_ON_ANCESTORS",
                        "CANNOT_DEPENDS_ON_DESCENDANTS":"CANNOT_DEPENDS_ON_DESCENDANTS",
                        "INVALID_DATE_FORMAT":"INVALID_DATE_FORMAT",
                        "TASK_MOVE_INCONSISTENT_LEVEL":"TASK_MOVE_INCONSISTENT_LEVEL",

                        "GANTT_QUARTER_SHORT":"trim.",
                        "GANTT_SEMESTER_SHORT":"sem."
                    };
                }


                //-------------------------------------------  Open a black popup for managing resources. This is only an axample of implementation (usually resources come from server) ------------------------------------------------------
                function openResourceEditor() {
                    var editor = $("<div>");
                    editor.append("<h2>Resource editor</h2>");
                    editor.addClass("resEdit");

                    for (var i in ge.resources) {
                        var res = ge.resources[i];
                        var inp = $("<input type='text'>").attr("pos", i).addClass("resLine").val(res.name);
                        editor.append(inp).append("<br>");
                    }

                    var sv = $("<div>save</div>").css("float", "right").addClass("btn btn-success").click(function() {
                        $(this).closest(".resEdit").find("input").each(function() {
                            var el = $(this);
                            var pos = el.attr("pos");
                            ge.resources[pos].name = el.val();
                        });
                        ge.editor.redraw();
                        closeBlackPopup();
                    });
                    editor.append(sv);

                    var ndo = createBlackPage(800, 500).append(editor);
                }

                //-------------------------------------------  Get project file as JSON (used for migrate project from gantt to Teamwork) ------------------------------------------------------
                function getFile() {
                    $("#gimBaPrj").val(JSON.stringify(ge.saveProject()));
                    $("#gimmeBack").submit();
                    $("#gimBaPrj").val("");

                    /*  var uriContent = "data:text/html;charset=utf-8," + encodeURIComponent(JSON.stringify(prj));
               neww=window.open(uriContent,"dl");*/
                }


                //-------------------------------------------  LOCAL STORAGE MANAGEMENT (for this demo only) ------------------------------------------------------
                Storage.prototype.setObject = function(key, value) {
                    this.setItem(key, JSON.stringify(value));
                };


                Storage.prototype.getObject = function(key) {
                    return this.getItem(key) && JSON.parse(this.getItem(key));
                };


                function loadFromLocalStorage() {
                    var ret;
                    if (localStorage) {
                        if (localStorage.getObject("teamworkGantDemo")) {
                            ret = localStorage.getObject("teamworkGantDemo");
                        }
                    } else {
                        $("#taZone").show();
                    }
                    if (!ret || !ret.tasks || ret.tasks.length == 0){
                        ret = JSON.parse($("#ta").val());


                        //actualiza data
                        var offset=new Date().getTime()-ret.tasks[0].start;
                        for (var i=0;i<ret.tasks.length;i++)
                            ret.tasks[i].start=ret.tasks[i].start+offset;


                    }
                    ge.loadProject(ret);
                    ge.checkpoint(); //empty the undo stack
                }


                function saveInLocalStorage() {
                    var prj = ge.saveProject();
                    if (localStorage) {
                        localStorage.setObject("teamworkGantDemo", prj);
                    } else {
                        $("#ta").val(JSON.stringify(prj));
                    }
                }


            </script>


            <div id="gantEditorTemplates" style="display:none;">
                <div class="__template__" type="GANTBUTTONS"><!--
                <div class="ganttButtonBar noprint">
                  <div class="buttons">
                  <button onclick="$('#workSpace').trigger('undo.gantt');" class="button textual" title="undo"><span class="teamworkIcon">&#39;</span></button>
                  <button onclick="$('#workSpace').trigger('redo.gantt');" class="button textual" title="redo"><span class="teamworkIcon">&middot;</span></button>
                  <span class="ganttButtonSeparator"></span>
                  <button onclick="$('#workSpace').trigger('addAboveCurrentTask.gantt');" class="button textual" title="insert above"><span class="teamworkIcon">l</span></button>
                  <button onclick="$('#workSpace').trigger('addBelowCurrentTask.gantt');" class="button textual" title="insert below"><span class="teamworkIcon">X</span></button>
                  <span class="ganttButtonSeparator"></span>
                  <button onclick="$('#workSpace').trigger('indentCurrentTask.gantt');" class="button textual" title="indent task"><span class="teamworkIcon">.</span></button>
                  <button onclick="$('#workSpace').trigger('outdentCurrentTask.gantt');" class="button textual" title="unindent task"><span class="teamworkIcon">:</span></button>
                  <span class="ganttButtonSeparator"></span>
                  <button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');" class="button textual" title="move up"><span class="teamworkIcon">k</span></button>
                  <button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');" class="button textual" title="move down"><span class="teamworkIcon">j</span></button>
                  <span class="ganttButtonSeparator"></span>
                  <button onclick="$('#workSpace').trigger('zoomMinus.gantt');" class="button textual" title="zoom out"><span class="teamworkIcon">)</span></button>
                  <button onclick="$('#workSpace').trigger('zoomPlus.gantt');" class="button textual" title="zoom in"><span class="teamworkIcon">(</span></button>
                  <span class="ganttButtonSeparator"></span>
                  <button onclick="$('#workSpace').trigger('deleteCurrentTask.gantt');" class="button textual" title="delete"><span class="teamworkIcon">&cent;</span></button>
                  <span class="ganttButtonSeparator"></span>
                  <button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();" class="button textual" title="Critical Path"><span class="teamworkIcon">&pound;</span></button>
                    &nbsp; &nbsp; &nbsp; &nbsp;
                    <button onclick="saveGanttOnServer();" class="btn btn-success big" title="save">save</button>
                  </div></div>
                    --></div>

                <div class="__template__" type="TASKSEDITHEAD"><!--
                <table class="gdfTable" cellspacing="0" cellpadding="0">
                  <thead>
                  <tr style="height:40px">
                    <th class="gdfColHeader" style="width:35px;"></th>
                    <th class="gdfColHeader" style="width:25px;"></th>
                    <th class="gdfColHeader gdfResizable" style="width:30px;">code/short name</th>
              
                    <th class="gdfColHeader gdfResizable" style="width:300px;">name</th>
                    <th class="gdfColHeader gdfResizable" style="width:80px;">start</th>
                    <th class="gdfColHeader gdfResizable" style="width:80px;">end</th>
                    <th class="gdfColHeader gdfResizable" style="width:50px;">dur.</th>
                    <th class="gdfColHeader gdfResizable" style="width:50px;">dep.</th>
                    <th class="gdfColHeader gdfResizable" style="width:200px;">assignees</th>
                  </tr>
                  </thead>
                </table>
                    --></div>

                <div class="__template__" type="TASKROW"><!--
                <tr taskId="(#=obj.id#)" class="taskEditRow" level="(#=level#)">
                  <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span> <span class="teamworkIcon" style="font-size:12px;" >e</span></th>
                  <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>
                  <td class="gdfCell"><input type="text" name="code" value="(#=obj.code?obj.code:''#)"></td>
                  <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10#)px;"><input type="text" name="name" value="(#=obj.name#)" style="(#=obj.level>0?'border-left:2px dotted orange':''#)"></td>
              
                  <td class="gdfCell"><input type="text" name="start"  value="" class="date"></td>
                  <td class="gdfCell"><input type="text" name="end" value="" class="date"></td>
                  <td class="gdfCell"><input type="text" name="duration" value="(#=obj.duration#)"></td>
                  <td class="gdfCell"><input type="text" name="depends" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>
                  <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
                </tr>
                    --></div>

                <div class="__template__" type="TASKEMPTYROW"><!--
                <tr class="taskEditRow emptyRow" >
                  <th class="gdfCell" align="right"></th>
                  <td class="gdfCell noClip" align="center"></td>
                  <td class="gdfCell"></td>
                  <td class="gdfCell"></td>
                  <td class="gdfCell"></td>
                  <td class="gdfCell"></td>
                  <td class="gdfCell"></td>
                  <td class="gdfCell"></td>
                  <td class="gdfCell"></td>
                </tr>
                    --></div>

                <div class="__template__" type="TASKBAR"><!--
                <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
                  <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
                    <div class="taskStatus" status="(#=obj.status#)"></div>
                    <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
                    <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>
              
                    <div class="taskLabel"></div>
                    <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
                  </div>
                </div>
                    --></div>

                <div class="__template__" type="CHANGE_STATUS"><!--
                  <div class="taskStatusBox">
                    <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="active"></div>
                    <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="completed"></div>
                    <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="failed"></div>
                    <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="suspended"></div>
                    <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="undefined"></div>
                  </div>
                    --></div>


                <div class="__template__" type="TASK_EDITOR"><!--
                <div class="ganttTaskEditor">
                <table width="100%">
                  <tr>
                    <td>
                      <table cellpadding="5">
                        <tr>
                          <td><label for="code">code/short name</label><br><input type="text" name="code" id="code" value="" class="form-control"></td>
                         </tr><tr>
                          <td><label for="name">name</label><br><input type="text" name="name" id="name" value=""  size="35" class="form-control"></td>
                        </tr>
                        <tr></tr>
                          <td>
                            <label for="description">description</label><br>
                            <textarea rows="5" cols="30" id="description" name="description" class="form-control"></textarea>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td valign="top">
                      <table cellpadding="5">
                        <tr>
                        <td colspan="2"><label for="status">status</label><br><div id="status" class="taskStatus" status=""></div></td>
                        <tr>
                        <td colspan="2"><label for="progress">progress</label><br><input type="text" name="progress" id="progress" value="" size="3" class="form-control"></td>
                        </tr>
                        <tr>
                        <td><label for="start">start</label><br><div class="form-inline"><input type="text" name="start" id="start"  value="" class="date form-control" size="10" style="margin-right:5px;"><input type="checkbox" id="startIsMilestone"></div> </td>
                        <td rowspan="2" class="graph" style="padding-left:50px"><label for="duration">dur.</label><br><input type="text" name="duration" id="duration" value=""  size="5" class="form-control"></td>
                      </tr><tr>
                        <td><label for="end">end</label><br><div class="form-inline"><input type="text" name="end" id="end" value="" class="date form-control"  size="10" style="margin-right:5px;"><input type="checkbox" id="endIsMilestone"></div></td>
                      </table>
                    </td>
                  </tr>
                  </table>
              
                  <h4>assignments</h4>
                <table  cellspacing="1" cellpadding="0" width="100%" id="assigsTable" class="table table-bordered">
                  <tr>
                    <th style="width:100px;">name</th>
                    <th style="width:70px;">role</th>
                    <th style="width:30px;">est.wklg.</th>
                    <th style="width:30px;" id="addAssig"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
                  </tr>
                </table>
              
                <div style="text-align: right; padding-top: 20px"><button id="saveButton" class="btn btn-success">save</button></div>
                </div>
                    --></div>


                <div class="__template__" type="ASSIGNMENT_ROW"><!--
                <tr taskId="(#=obj.task.id#)" assigId="(#=obj.assig.id#)" class="assigEditRow" >
                  <td ><select name="resourceId"  class="form-control" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
                  <td ><select type="select" name="roleId"  class="form-control"></select></td>
                  <td ><input type="text" name="effort" value="(#=getMillisInHoursMinutes(obj.assig.effort)#)" size="5" class="form-control"></td>
                  <td align="center"><span class="teamworkIcon delAssig" style="cursor: pointer">d</span></td>
                </tr>
                    --></div>

            </div>
            <script type="text/javascript">
                $.JST.loadDecorator("ASSIGNMENT_ROW", function(assigTr, taskAssig) {

                    var resEl = assigTr.find("[name=resourceId]");
                    for (var i in taskAssig.task.master.resources) {
                        var res = taskAssig.task.master.resources[i];
                        var opt = $("<option>");
                        opt.val(res.id).html(res.name);
                        if (taskAssig.assig.resourceId == res.id)
                            opt.attr("selected", "true");
                        resEl.append(opt);
                    }


                    var roleEl = assigTr.find("[name=roleId]");
                    for (var i in taskAssig.task.master.roles) {
                        var role = taskAssig.task.master.roles[i];
                        var optr = $("<option>");
                        optr.val(role.id).html(role.name);
                        if (taskAssig.assig.roleId == role.id)
                            optr.attr("selected", "true");
                        roleEl.append(optr);
                    }

                    if(taskAssig.task.master.canWrite && taskAssig.task.canWrite){
                        assigTr.find(".delAssig").click(function() {
                            var tr = $(this).closest("[assigId]").fadeOut(200, function() {
                                $(this).remove();
                            });
                        });
                    }


                });
            </script>
        </div>
<div class="table-responsive">

    <div id="dataTable"></div>
    <script>
        var data = [
<?php
foreach ($issues as $row):
    $subject = str_replace("\"", "", mb_strimwidth($row['subject'] , 0, 15,'...'));
    ?>
                ["#<?= $row['id']; ?>", "<?= $row['root_id']; ?>", "<?= $row['parent_id']; ?>", "<?= $subject; ?>","","","<?= $row['priority_id']; ?>", "<?= $row['done_ratio']; ?>", "<?= $row['estimated_hours']; ?>", "<?= $row['start_date']; ?>", "<?= $row['due_date']; ?>", "<?= $row['assigned_to_id']; ?>"],
    <?php
    if (count($row['child']) > 0):
        foreach ($row['child'] as $childrow):
    $csubject = str_replace("\"", "", mb_strimwidth($childrow['subject'] , 0, 15,'...'));
            ?>
                                ["#<?= $childrow['id']; ?>", "<?= $childrow['root_id']; ?>", "<?= $childrow['parent_id']; ?>","","<?= $csubject; ?>","","<?= $childrow['priority_id']; ?>", "<?= $childrow['done_ratio']; ?>", "<?= $childrow['estimated_hours']; ?>", "<?= $childrow['start_date']; ?>", "<?= $childrow['due_date']; ?>", "<?= $childrow['assigned_to_id']; ?>"],
            <?php
            if (count($childrow['child']) > 0):
                foreach ($childrow['child'] as $cchildrow):
    $ccsubject = str_replace("\"", "", mb_strimwidth($cchildrow['subject'] , 0, 15,'...'));
                    ?>
                                                ["#<?= $cchildrow['id']; ?>", "<?= $cchildrow['root_id']; ?>", "<?= $cchildrow['parent_id']; ?>","","","<?= $ccsubject; ?>","<?= $cchildrow['priority_id']; ?>", "<?= $cchildrow['done_ratio']; ?>", "<?= $cchildrow['estimated_hours']; ?>", "<?= $cchildrow['start_date']; ?>", "<?= $cchildrow['due_date']; ?>", "<?= $cchildrow['assigned_to_id']; ?>"],
                    <?php
                endforeach;
            endif;

        endforeach;
    endif;


endforeach;
?>
    ];
    $("#dataTable").handsontable('selectCell');
    $("#dataTable").handsontable({
        data: data,
        startRows: 6,
        currentRowClassName: 'currentRow',
        currentColClassName: 'currentCol',
        autoWrapRow: true,
        colHeaders: ["id", "root_id", "parent_id", "subject"," "," ","priority_id", "done_ratio", "estimated_hours", "start_date", "due_date", "assigned_to_id"],
        columns: [
            {
                //simple text, no special options here id
            },
            {
                //simple text, no special options here root_id
            },
            {
                //simple text, no special options here parent_id
            },
            {
                //simple text, no special options here subject
            },
            {
                //simple text, no special options here subject
            },
            {
                //simple text, no special options here subject
            },
            {
                //simple text, no special options here priority_id
            },
            {
                //simple text, no special options here done_ratio
                type: 'dropdown',
                source: ["0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100"]
            },
            {
                //simple text, no special options here estimated_hours
                type: 'numeric',
                format: '0.0'
            },
            {
                //start_date
                type: 'date',
                dateFormat: 'yy-mm-dd'
            },
            {
                //due_date
                type: 'date',
                dateFormat: 'yy-mm-dd'
            },
            {
                //simple text, no special options here assigned_to_id
            }
        ]

    });
    
    </script>

</div>