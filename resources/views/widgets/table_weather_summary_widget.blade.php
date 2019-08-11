<div class="table-weather-summary">
    <h2 class="text-center">El tiempo ahora</h2>

    <hr />

    <table class="table table-sm table-bordered
                          table-hover text-center table-weather-sumary">
        <thead class="thead-dark">
        <tr data-route="{{route('index')}}">
            <th>Sensor</th>
            <th>Valor</th>
            <th>Medida</th>
        </tr>
        </thead>

        <tbody>
        <tr data-route="{{route('index')}}">
            <td>
                <i class="wi wi-thermometer"></i>
                Temperatura
            </td>
            <td>29</td>
            <td>ºC</td>
        </tr>

        <tr data-route="{{route('index')}}">
            <td>
                <i class="wi wi-barometer"></i>
                Presión
            </td>
            <td>1011.38</td>
            <td>mmHg</td>
        </tr>

        <tr data-route="{{route('index')}}">
            <td>
                <i class="wi wi-humidity"></i>
                Humedad
            </td>
            <td>59</td>
            <td>%</td>
        </tr>

        <tr data-route="{{route('index')}}">
            <td>
                <i class="wi wi-sunset"></i>
                Cantidad Luz
            </td>
            <td>4061</td>
            <td>Lux</td>
        </tr>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="3">
                <a href="{{route('index')}}"
                   title="Ver detalles del tiempo en Chipiona"
                   class="btn btn-success mt-1 mb-1">
                    <strong>
                        <i class="wi wi-day-sunny"></i>
                        Ver más detalles
                        <i class="fa fa-forward"></i>
                    </strong>
                </a>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
