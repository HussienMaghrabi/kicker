<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            vacancy Types
                        </p>
                    </div>
                </div>
                <div class="padding level-right">
                  <router-link :to="'/admin/vue/AddVtype'">
                      <b-button type="is-info">Add New</b-button>
                  </router-link>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-12">
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>
