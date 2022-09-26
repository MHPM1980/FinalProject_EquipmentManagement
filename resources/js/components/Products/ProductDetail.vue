<template>
    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Detalhes de Equipamento</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <img class="offset-md-3" src="/img/products/portatil.jpg" alt="Product Image"
                                 style="width: 350px; height: 350px; object-fit: contain">
                        </div>
                        <div class="col-12 col-lg-6 justify-content-center">
                            <div>
                                <label class="col-3 text-right pb-3" for="EquipmentId">ID:</label>
                                <input class="col-8" id="EquipmentId" type="text" disabled>
                                <label class="col-3 text-right pb-3" for="EquipmentName">Nome:</label>
                                <input class="col-8" id="EquipmentName" type="text" disabled>
                                <label class="col-3 text-right pb-3" for="EquipmentDescription">Descrição:</label>
                                <input class="col-8" id="EquipmentDescription" type="text" disabled>
                                <label class="col-3 text-right pb-3" for="EquipmentSerialNumber">Nº de Série:</label>
                                <input class="col-8" id="EquipmentSerialNumber" type="text" disabled>
                                <label class="col-3 text-right pb-3" for="EquipmentCategory">Categoria:</label>
                                <input class="col-8" id="EquipmentCategory" type="text" disabled>
                                <label class="col-3 text-right pb-3" for="EquipmentWarehouse">Armazém:</label>
                                <input class="col-8" id="EquipmentWarehouse" type="text" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" style="width: 100%; height: 330px; border: solid black 1px;">
                        IMPLEMENTAR CALENDÁRIO
                    </div>
                    <div class="text-right pt-3">
                        <button class="btn btn-danger" @click="$router.push('equipments')">Fechar</button>
                        <button class="btn btn-primary" @click="$router.push('reservations')">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
