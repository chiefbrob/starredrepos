<template>
  <div>
    <nav-root></nav-root>
    <div class="row py-5 mb-5">
      <div class="col-md-8 offset-md-2">
        <b-jumbotron bg-variant="info" text-variant="white" border-variant="dark">
          <template #header>Starred Repositories</template>

          <template #lead>
            This application connects to your github account and fetches your starred Repositories.
          </template>

          <hr class="my-4" />

          <p>
            It uses github token. More notes on how to generate a token can be found
            <a target="_blank" href="https://github.com/settings/tokens">here</a>
          </p>
          <p><b-button href="/home" variant="dark" size="sm">Get Started</b-button></p>
        </b-jumbotron>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>
