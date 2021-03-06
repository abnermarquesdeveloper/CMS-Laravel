@extends('adminlte::page')
@section('plugins.Chartjs',true) <!-- habilta o plugin do AdminLTE para gráficos  -->


@section('title', 'Painel')


@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-6">
            <div class="row float-md-right">
                <h5 style="padding-right: 10px">Ver acessos:</h5>
                <form method="GET">
                    <select onChange="this.form.submit()" name="interval" style="margin-right: 12px">
                        <option {{$dateInterval === 7 ? 'selected="selected"' : ''}} value="7">Últimos 7 dias</option>
                        <option {{$dateInterval === 15 ? 'selected="selected"' : ''}} value="15">Últimos 15 dias</option>
                        <option {{$dateInterval === 30 ? 'selected="selected"' : ''}} value="30">Últimos 30 dias</option>
                        <option {{$dateInterval === 60 ? 'selected="selected"' : ''}} value="60">Últimos 2 meses</option>
                        <option {{$dateInterval === 90 ? 'selected="selected"' : ''}} value="90">Últimos 3 meses</option>
                    </select>
                </form>
            </div>
        </div>
    </>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$visitsCount}}</h3>
                    <p>Acessos</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$onlineCount}}</h3>
                    <p>Usuários Online</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$pageCount}}</h3>
                    <p>Páginas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-sticky-note"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$userCount}}</h3>
                    <p>Usuários</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-user"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="pagePie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sobre o Sistema</h3>
                </div>
                <div class="card-body">
                    Texto sobre o Sistema
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function(){
            let ctx = document.getElementById('pagePie').getContext('2d');
            window.pagePie = new Chart(ctx, {
                type:'pie',
                data:{
                    datasets:[{
                        data:{{$pageValues}},
                        backgroundColor:'#0000FF'
                    }],
                    labels:{!!$pageLabels!!}// colocar as exclamações para tirar os "escapes" se não fica com erro não mostrando o gráfico
                },
                options:{
                    responsive:true,
                    legend:{
                        display:false
                    },
                },
            });
        }
    </script>

@endsection