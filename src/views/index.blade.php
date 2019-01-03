@extends('PackageGenerator::layouts.app')
<style>

    #project-edit, #project-save, #project-name, #project-add {
        display: none;
    }

    .module {
        width: 100%;
        border: 1px solid #e3e3e3;
        margin-bottom: 20px;
        text-align: center;
        vertical-align: middle !important;
        box-shadow: rgb(3.10 .4 .255);
    }

    #addAttribute {
        cursor: pointer;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form class="form-inline float-left">

                            <h3 id="display-project-name"></h3>
                            <input class="form-control form-control-sm" type="text" name="project-name"
                                   id="project-name"/>
                            &nbsp;
                            <button type="button" id="project-add" class="project-btn btn btn-sm btn-success">Add
                            </button>

                            <button type="button" id="project-edit" class="project-btn btn btn-sm btn-success">Edit
                            </button>
                            <button type="button" id="project-save" class="project-btn btn btn-sm btn-success">Save
                            </button>
                        </form>

                        <div class="float-right">
                            <input name="module-name" id="module-name" required/>
                            <input type="checkbox" name="has-menu" id="has-menu"/>
                            <button id="add-module" class="btn btn-success btn-sm">+ Module</button>
                            <button id="save-module" class="btn btn-success btn-sm">Save</button>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                @foreach($modules as $module)
                                    <div class="col-sm-4">
                                        <div class="module">
                                            <h5>
                                                {{ $module->name }}
                                                <span class="text-danger removeModule"
                                                      value="{{ $module->id }}">-</span>
                                                <span style="font-size: 12px; padding: 6px"
                                                      class="float-right addAttribute" value="{{ $module->id }}">Add Attr</span>
                                            </h5>
                                            <form class="form-inline">
                                                <input class="form-control form-control-sm" size="8" type="text"
                                                       name="name" id="name" placeholder="name"/>

                                                <select class="form-control form-control-sm" name="type" id="type"
                                                        placeholder="type">
                                                    <option>One</option>
                                                    <option>Two</option>
                                                    <option>Three</option>
                                                </select>
                                                <input class="form-control form-control-sm" size="5" type="checkbox"
                                                       name="unsigned" id="unsigned"/>
                                                <input class="form-control form-control-sm" size="5" type="checkbox"
                                                       name="unique" id="unique"/>
                                                <button>Save</button>
                                                <button>Done</button>
                                            </form>
                                            @foreach($module->ModuleAttribute as $attribute)
                                                <div>{{
                                                    $attribute->name . ", " .
                                                    $attribute->type . ", " .
                                                    $attribute->unsigned . ", " .
                                                    $attribute->unique . ', ' .
                                                    $attribute->nullable }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <button id="finish" class="btn btn-success btn-sm">Finish >></button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            getMessage();
            var moduleName = $("#module-name");
            var moduleSave = $("#save-module");

            var projectName = $("#project-name");
            var removeModule = $(".removeModule");
            var projectAdd = $("#project-add");
            var projectEdit = $("#project-edit");
            var projectSave = $("#project-save");
            var finish = $("#finish");
            var displayProjectName = $("#display-project-name");

            moduleSave.click(function () {
                var name = moduleName.val();
                addModuleToDb(name);

            });

            function getMessage() {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '{{ url('project') }}',
                    success: function (data) {
                        if (data.project !== null) {
                            projectExists(data.project);
                        } else {
                            projectDoesNotExists(data.project);
                        }
                    }
                });
            }

            removeModule.click(function () {

                var moduleId = $(this).attr('value');

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {moduleId: moduleId},
                    url: '{{ url('delete-module') }}',
                    success: function (data) {
                        alert(data);
                        location.reload();
                    }
                });

            });

            projectSave.click(function () {

                $(this).css('display', 'none');
                projectEdit.css('display', 'block');
                displayProjectName.css('display', 'block');
                displayProjectName.html(projectName.val());
                projectName.css('display', 'none');

                addProject(projectName.val());
            });


            projectAdd.click(function () {
                var name = $("#project-name").val();

                if (name !== '') {

                    addProject(name);

                    projectAdd.css('display', 'none');
                    projectName.css('display', 'none');
                    displayProjectName.html(name);
                    displayProjectName.css('display', 'block');
                    projectEdit.css('display', 'block');
                }
            });

            projectEdit.click(function () {
                displayProjectName.css('display', 'none');
                projectName.css('display', 'block');
                $(this).css('display', 'none');
                projectSave.css('display', 'block');
            });

            /**
             *  add / edit project
             */
            function addProject(name) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('add') }}',
                    data: {name: name},
                    success: function (data) {
                        console.log(data);
                    }
                });
            }

            finish.click(function () {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('finish') }}',
                    success: function (data) {
                        console.log(data);
                    }
                });
            });

            /**
             * Add module to databse
             * */
            function addModuleToDb(name) {

                if (name !== '') {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('add-module') }}',
                        data: {name: name},
                        success: function (data) {
                            console.log(data);
                            location.reload();
                        }
                    });
                } else {
                    alert('name cannot be empty');
                }

            }

            /**
             *
             * @param project
             */
            function projectExists(project) {
                projectName.val(project.name);
                displayProjectName.text(project.name);
                projectEdit.css('display', 'block');
            }

            /**
             *  project not in system
             */
            function projectDoesNotExists() {
                projectName.css('display', 'block');
                projectAdd.css('display', 'block');
            }
        });
    </script>
@endsection
