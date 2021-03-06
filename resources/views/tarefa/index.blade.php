@extends('layouts.internal')
<style>
    body{
        background-color: #e7eaeb !important;
    }
    #corpo{
        background-color: gray;
    }
    .fa:hover{
        cursor: pointer;
    }
</style>
@section('content')
<div class="row">
    <div class="col-sm-12 mt-1 p-3 mb-2">
        <div class="h1">
            Meus compromissos
        </div>
    </div>

    <div class="row">
        <form class="row" method="GET" action="{{route('tarefa.index')}}" accept-charset="UTF-8">
            <input type="submit" value="Submit" style="display: none">
            <div class="col-xs-12 col-sm-12 form-group" >
                <label class="checkbox checkbox-custom-alt text-primary">
                    <input type="checkbox" name="only_future_appointments_filter">
                    <strong><em class="fa fa-filter"></em>Apenas compromissos futuros</strong>
                </label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 form-group">
                <label>Título</label>
                <input type="text" class="form-control" placeholder="Ir à missa..." name="title_filter"
                />
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 form-group">
                <label>Descrição</label>
                <input type="text" class="form-control" placeholder="Ir à missa..." name="description_filter"
                />
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 form-group">
                <label>Data de criação</label>
                <input type="date" class="form-control" placeholder="Ir à missa..." name="creation_date_filter"
                />
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 form-group">
                <label>Total de vezes relembrado</label>
                <input type="number" class="form-control" placeholder="0" name="total_reminders_filter"
                />
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 form-group">
                <label>Data lembrete</label>
                <input type="date" class="form-control" placeholder="Ir à missa..." name="reminder_date_filter"
                />
            </div>


            <div class="col-xs-12 col-sm-12 col-md-1 form-group" style="padding-top: 1.4rem !important;">
                <button data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Filtrar" class="btn form-control btn-info"><i aria-hidden="true" class="fa fa-filter"></i> Filtrar
                </button>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-1 form-group" style="padding-top: 1.4rem !important;">
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn-new-appointment" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Filtrar" class="btn form-control btn-success"><i aria-hidden="true" class="fa fa-plus"></i> Novo
                </button>
            </div>

        </form>
    </div>

    <div class="col-sm-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Título</th>
                    <th scope="col">Data de criação</th>
                    <th scope="col">Lembrar em</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <th scope="row">{{$appointment->id}}</th>
                        <td>{{$appointment->title}}</td>
                        <td>{{$appointment->created_at->format('d/m/Y, \à\s H:i:s')}}</td>
                        <td>{{$appointment->date_reminder->format('d/m/Y, \à\s H:i:s')}}</td>
                        <td>
                            <a onclick="event.preventDefault()" data-toggle="tooltip" data-placement="bottom" title="" href="" class="btn btn-primary" data-original-title="Visualizar">
                                <i aria-hidden="true" class="fa fa-search"></i>
                            </a>

                            <a href="" data-datetime="{{$appointment->date_reminder->format('Y-m-d\TH:i:s')}}" data-item="{{$appointment->toJson()}}" data-bs-toggle="modal" data-bs-target="#modal-edicao" onclick="event.preventDefault(); atualizarCompromisso(this);" class="btn-warning btn">
                                <i  class="fa a fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <form style="display: none;" method="POST" action="{{route('tarefa.destroy', $appointment->id)}}" id="appointment-delete-{{$appointment->id}}">
                                @csrf
                                @method('DELETE')
                            </form>

                            <a href="" onclick="event.preventDefault(); if(confirm('Tem certeza?')){document.getElementById('appointment-delete-{{$appointment->id}}').submit()}" class="btn btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                       <td colspan="5" class="text-center">
                            <h4>Você não possui compromissos.</h4>
                       </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        {{ $appointments->links() }}
    </div>
</div>
@endsection

@section('script')
<script>
    function atualizarCompromisso(elemento){
        const item = JSON.parse(elemento.getAttribute('data-item'));
        const datetime = elemento.getAttribute('data-datetime');
        const form = document.getElementById('form-edit-compromisso');

        form.action = form.action.replace('/0', '/' + item.id);
        document.getElementById('title-edit').value = item.title
        document.getElementById('description-edit').value = item.description;
        document.getElementById('date_reminder-edit').value = datetime;
    }

    $(document).ready(function(){
        document.getElementById("btn-new-appointment").addEventListener("click", function(event){
            event.preventDefault();
        });
    });
</script>
@endsection

@section('modals')
<!-- Modal cadastro -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de compromisso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-novo-compromisso" action="{{route('tarefa.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input value="{{ old('title') }}" type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp" placeholder="Título do compromisso">
                        <!-- <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small> -->
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6 col-lg-6 col-xs-6">
                    <div class="form-group">
                        <label for="date_reminder">Lembrar em</label>
                        <input value="{{ old('date_reminder') }}" type="datetime-local" class="form-control" name="date_reminder" id="date_reminder" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea value="{{ old('description') }}" class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button onclick="document.getElementById('form-novo-compromisso').submit();" type="button" class="btn btn-success">Cadastrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal cadastro -->
<div class="modal fade" id="modal-edicao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edição de compromisso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-edit-compromisso" action="{{route('tarefa.update', 0)}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="appointment-id">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                    <div class="form-group">
                        <label for="title-edit">Título</label>
                        <input type="text" class="form-control" name="title" id="title-edit" aria-describedby="emailHelp" placeholder="Título do compromisso">
                        <!-- <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small> -->
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6 col-lg-6 col-xs-6">
                    <div class="form-group">
                        <label for="date_reminder-edit">Lembrar em</label>
                        <input type="datetime-local" class="form-control" name="date_reminder" id="date_reminder-edit" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
                    <div class="form-group">
                        <label for="description-edit">Descrição</label>
                        <textarea class="form-control" name="description" id="description-edit" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button onclick="document.getElementById('form-edit-compromisso').submit();" type="button" class="btn btn-success">Salvar</button>
      </div>
    </div>
  </div>
</div>


@endsection
