<template>
  <div id="app">
      <nav class="navbar  nav">
        <div class="container">
           <a class="navbar-brand text-white" href="#">
             <b>MyCar</b> Revisões
           </a>
        </div>
      </nav>
      <div class="jumbotron ">
        <div class="container">
          <h1 class="display-4">{{$route.name}}</h1>
          <p class="lead">Aplicação para revisões de veiculos</p>
          <hr class="my-4">
          <p class="lead">
            <a class="btn txt-color btn-sm" href="/veiculos" role="button">Veiculos</a>
            <a class="btn txt-color btn-sm" href="/ClientesMostrar" role="button">Clientes</a>
            <a class="btn txt-color btn-sm" href="/Revisoes" role="button">Revisões</a>
          </p>
        </div>
      </div>
      <div class="container margin">
        <div class="card">
          <div class="card-body">
              <router-view/>
          </div>
        </div>
      </div>
  </div>
</template>

<style>
  .nav {
    background: #120207;
  }
  .txt-color {
    color: #3f51b5;
  }
  .margin{
    margin-top: 1rem;
  }
  div .jumbotron{
    background-color: #f7b6cc;
    color: #49081f;
  }
  div .card-body{
    background-color: #fdedf2;
    color: #49081f;
  }
 
</style>
