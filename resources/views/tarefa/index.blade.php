@extends('layouts.internal')
<style>
    #corpo{
        background-color: gray;
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <i class="fa fa-trash" aria-hidden="true"></i>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')

@endsection

@section('modals')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Criação de compromisso</h5>
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
            <!-- <div class="form-group">
                <label for="exampleInputEmail1">Endereço de email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Seu email">
                <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Senha</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
            </div> -->
            <!-- <button type="submit" class="btn btn-primary">Enviar</button> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button onclick="document.getElementById('form-novo-compromisso').submit();" type="button" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>


@endsection