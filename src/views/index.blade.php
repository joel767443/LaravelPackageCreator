@extends('PackageGenerator::layouts.app')
<style>

    #project-name, #project-add, #project-edit, #project-save {
        display: none;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form class="form-inline">

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

                    </div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                @foreach($modules as $module)
                                    <div class="col-sm-3"> {{ $module }}</div>
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
            var projectName = $("#project-name");
            var projectEdit = $("#project-edit");
            var projectSave = $("#project-save");
            var finish = $("#finish");
            var displayProjectName = $("#display-project-name");

            function getMessage() {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/project',
                    success: function (data) {
                        if (data.project !== null) {
                            projectExists(data.project);
                        }
                    }
                });
            }

            projectSave.click(function () {

                $(this).css('display', 'none');
                projectEdit.css('display', 'block');
                displayProjectName.css('display', 'block');
                displayProjectName.html(projectName.val());
                projectName.css('display', 'none');


                // change stuf
                // save stuff
            });

            projectEdit.click(function () {
                displayProjectName.css('display', 'none');
                projectName.css('display', 'block');
                $(this).css('display', 'none');
                projectSave.css('display', 'block');
            });

            finish.click(function () {
                $.ajax({
                    type: 'GET',
                    url: 'finish',
                    success: function (data) {
                        console.log(data);
                    }
                });
            });

            /**
             *
             * @param project
             */
            function projectExists(project) {
                projectName.val(project.name);
                displayProjectName.text(project.name);
                projectEdit.css('display', 'block');
            }
        });
    </script>
@endsection
