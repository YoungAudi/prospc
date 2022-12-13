<script>
    var table_{{$id}} = null;
    KTUtil.onDOMContentLoaded(function() {
        table_{{$id}} = $("#{{$id}}").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{$route}}",
                "data": function ( d ) {
                    {{$data??""}}
                }
            },
            "drawCallback": function(oSettings, json) {
                {{$callback??''}}
            },
            columns: {{$slot}},
            "language": {
                "lengthMenu": "{{__("datatables.lengthMenu")}}",
                "zeroRecords": "{{__("datatables.zeroRecords")}}",
                "info": "{{__("datatables.info")}}",
                "infoEmpty": "{{__("datatables.infoEmpty")}}",
                "infoFiltered": "{{__("datatables.infoFiltered")}}",
                "search": "{{__("datatables.search")}}",
                "processing": "{{__("datatables.processing")}}",
                "loadingRecords": "{{__("datatables.loadingRecords")}}",
                "emptyTable": "{{__("datatables.emptyTable")}}",
            },
            @if(!isset($nothing) || !$nothing)
            @if(!isset($searchable) || $searchable)
            "dom":
              "<'row d-flex flex-wrap'" +
              "<'col-sm-12 d-flex align-items-center justify-content-start'B>" +
              "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
              "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
              ">" +

              "<'table-responsive'tr>" +

              "<'row'" +
              "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
              "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
              ">",
              @else
              "dom":
              "<'row d-flex flex-wrap'" +
              "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
              "<'col-sm-6 d-flex align-items-center justify-content-end'B>" +
              ">" +

              "<'table-responsive'tr>" +

              "<'row'" +
              "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
              "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
              ">",
              @endif
              @endif
            "buttons": [
                'copy', 'excel', 'pdf',
            ]
        });
    });
</script>