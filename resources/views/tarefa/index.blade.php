@extends('layouts.internal')
<style>
    #corpo{
        background-color: gray;
    }
    .fa:hover{
        cursor: pointer;
    }
</style>
@section('content')
<div class="row">
    <div class="col-sm-12 text-center mt-1">
        <div class="h1">
            Minhas tarefas
        </div>
    </div>

    <div class="col-sm-12 p-2" style="background-color: gray;">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa fa-2x fa-plus-circle" style="color: white;" aria-hidden="true"></i>
        </button>
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
                        <td>{{$appointment->created_at}}</td>
                        <td>{{$appointment->date_reminder}}</td>
                        <td>
                            <a onclick="event.preventDefault()" data-toggle="tooltip" data-placement="bottom" title="" href="" class="btn btn-primary" data-original-title="Visualizar">
                                <i aria-hidden="true" class="fa fa-search"></i>
                            </a>

                            <a href="" data-item="{{$appointment->toJson()}}" data-bs-toggle="modal" data-bs-target="#modal-edicao" onclick="event.preventDefault(); atualizarCompromisso(this); " class="btn-warning btn">
                                <i  class="fa a fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <form style="display: none;" method="POST" action="{{route('tarefa.destroy', $appointment->id)}}" id="appointment-delete-{{$appointment->id}}">
                                @csrf
                                @method('DELETE')
                            </form>

                            <a href="" onclick="event.preventDefault(); if(confirm('kkkk')){document.getElementById('appointment-delete-{{$appointment->id}}').submit()}" class="btn btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    function atualizarCompromisso(elemento){
        const item = JSON.parse(elemento.getAttribute('data-item'));
        const form = document.getElementById('form-edit-compromisso');
        document.getElementById('description-edit').value = item.description;
        document.getElementById('date_reminder-edit').value = new Date(item.date_reminder+"+00:00").toJSON().slice(0,19);
        document.getElementById('title-edit').value = item.title;
        form.action = form.action.replace('/0', '/' + item.id);
    }
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
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp" placeholder="Título do compromisso">
                        <!-- <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small> -->
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6 col-lg-6 col-xs-6">
                    <div class="form-group">
                        <label for="date_reminder">Lembrar em</label>
                        <input type="datetime-local" class="form-control" name="date_reminder" id="date_reminder" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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
