@extends('layouts.master')

@section('css')
    <style>
        .extra-form {
            /*position: absolute;*/
            /*z-index: 9;*/
            /*right: 240px;*/
        }
    </style>
@endsection
@section('content')
    <p> this is welcome page </p>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row p-1">
                                <input type="text" id="make" class="form-control col-md-3 mr-1" placeholder="search by make">
                                <input type="text" id="model" class="form-control col-md-3 mr-1" placeholder="search by model">
                                <input type="text" id="property" class="form-control col-md-3 mr-1" placeholder="search by property">
                            </div>
                            <div class="row p-1">
                                <select id="sort" class="form-control col-md-3">
                                    <option value="0"> Select Sort </option>
                                    <option value="make"> Sort By Make </option>
                                    <option value="model"> Sort By Model </option>
                                    <option value="property"> Sort By Property </option>
                                </select>
                            </div>
                            <div class="row p-1">
                                <button class="btn btn-primary" onclick="showColumns()"> Show All Columns </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="parent_table" class="table">
                                <thead>
                                <tr>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>License</th>
                                    <th>Email</th>
                                    <th>Property</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>

        var table;
        $(document).ready(function () {
            table = $('#parent_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                lengthMenu: [[10, 25, 50, 100, 1000000], [10, 25, 50, 100, "All"]],
                ajax: {
                    url: "{{route('vehicles.ajax')}}",
                    type: "post",
                    "data": function (d) {
                        d._token = "{{csrf_token()}}"
                        d.make = $('#make').val();
                        d.model = $('#model').val();
                        d.property = $('#property').val();
                        d.sort = $('#sort').val();
                    }, error: function () {  // error handling
                        $(".example-error").html("");
                        $("#example").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#example_processing").css("display", "none");
                    },
                    // dataSrc: function (json) {
                    //     console.log(json)
                    // }
                },
                "columns": [
                    {
                        "data": "make",
                    },
                    {
                        "data": "model",
                    },
                    {
                        "data": "license"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "property.name",
                    },
                ],
            });
        })

        $('#make').keyup(function () {
            table.draw();
        });

        $('#model').keyup(function () {
            table.draw();
        })

        $('#property').keyup(function () {
            table.draw();
        })

        $('#sort').on('change', function () {
            table.draw();
        })

        function showColumns() {
            var columns = table.settings().init().columns;
            console.log(columns);
        }
    </script>
@endsection
