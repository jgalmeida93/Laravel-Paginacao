<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Paginação</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <!-- Styles -->
        <style>
            body {
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card text-center">
                <div class="card-header">
                    Tabela de clientes
                </div>
                <div class="card-body">
                <h5 class="card-title" id="cardTitle"></h5>
                    <table class="table table-hover" id="tabelaClientes">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">Email</th>
                        </thead>
                        <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>Marcel</td>
                                    <td>Teorodo</td>
                                    <td>marcel@gmail.com</td>
                                </tr>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav id="paginator">
                        <ul class="pagination">
                          {{-- <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</span></a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                          </li> --}}
                        </ul>
                      </nav>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        <script type="text/javascript">

        function getItemProximo(data) {
            i = data.current_page + 1;
            if( data.last_page == data.current_page ) {
                string = '<li class="page-item disabled">';
            } else {
                    string = '<li class="page-item">';
                    string += '<a class="page-link" ' + 'pagina="' + i + '" href="#">Próximo</a></li>';
                    return string;
            }
        }

        function getItemAnterior(data) {
            i = data.current_page - 1;
            if( 1 == data.current_page) {
                string = '<li class="page-item disabled">';
            } else {
                    string = '<li class="page-item">';
                    string += '<a class="page-link"' + 'pagina="' + i + '" href="#">Anterior</a></li>';
                    return string;
            }

        }
        function getItem(data, i) {
            if( i == data.current_page) {
                string = '<li class="page-item active">';
            } else {
                    string = '<li class="page-item">';
            }
                string += '<a class="page-link" ' + 'pagina="' + i + '" href="#">' + i + '</a></li>';
                return string;

        }

        function montarPaginator(data) {
            $("#paginator>ul>li").remove();
            $("#paginator>ul").append(getItemAnterior(data));

            n = 10;

            if(data.current_page - n/2 <= 1) {
                inicio = 1;
            } else if (data.last_page - data.current_page < n) {
                inicio = data.last_page - n + 1;
            } else {
                inicio = data.current_page - n/2
            }
            fim = inicio + n - 1;

            for(i = inicio; i <= fim; i++) {
                string = getItem(data, i);
                $("#paginator>ul").append(string);

            }
            $("#paginator>ul").append(getItemProximo(data));
        }

            function montarLinha(cliente) {
                return '<tr>' +
                    '<td>'+ cliente.id + '</td>' +
                    '<td>'+ cliente.nome + '</td>' +
                    '<td>'+ cliente.sobrenome + '</td>' +
                    '<td>'+ cliente.email + '</td>' +
                '</tr>';
            }

            function montarTabela(data) {
                $("#tabelaClientes>tbody>tr").remove();
                for(i = 0; i < data.data.length; i++) {
                    string = montarLinha(data.data[i]);
                    $("#tabelaClientes>tbody").append(string);

                }
            }
            function carregarClientes(pagina) {
                $.get('/json', {page: pagina}, function(resp) {
                     console.log(resp)
                     montarTabela(resp);
                     montarPaginator(resp);
                     $('#paginator>ul>li>a').click(function () {
                        carregarClientes($(this).attr('pagina'));
                    });
                    $("#cardTitle").html(`Exibindo ${resp.per_page} clientes de ${resp.total}
                    (${resp.from} a ${resp.to})`);
                });

            }
            $(function() {
                carregarClientes(1);

            });
        </script>
    </body>
</html>
