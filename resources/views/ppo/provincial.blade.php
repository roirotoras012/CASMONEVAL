<x-app>

    <div class="container">
        <h1>Provincial view of OPCR</h1>
        <x-opcr_table :provinces=$provinces  :measures=$measures :annual_targets=$annual_targets/>
        
        <div class="row">
            <div class="col-6 mx-auto">
                <x-add_driver_form :opcrs=$opcrs :divisions=$divisions />
            </div>
            <div class="col-12 d-flex">
                <x-group_driver_form :measures=$measures :drivers=$driversact />
            </div>
        </div>

        <x-opcr_table_driver :provinces=$provinces :driversact=$driversact :measures=$measures :annual_targets=$annual_targets/>
    </div>

</x-app>