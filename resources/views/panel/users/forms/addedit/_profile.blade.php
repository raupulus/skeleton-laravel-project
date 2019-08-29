- Nombre
- Teléfono
- Descripción
- Biografía

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre" />
        </div>
    </div>
</div>




<div class="row">
    <div class="col-12">
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Básicos</h3>
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-sm-5 pb-3">
                        <label for="exampleAccount">Account #</label>
                        <input class="form-control" id="exampleAccount" placeholder="XXXXXXXXXXXXXXXX" type="text">
                    </div>
                    <div class="col-sm-3 pb-3">
                        <label for="exampleCtrl">Control #</label>
                        <input class="form-control" id="exampleCtrl" placeholder="0000" type="text">
                    </div>
                    <div class="col-sm-4 pb-3">
                        <label for="exampleAmount">Amount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                $
                            </div>
                            <input class="form-control" id="exampleAmount" placeholder="Amount" type="number">
                        </div>
                    </div>
                    <div class="col-sm-6 pb-3">
                        <label for="exampleFirst">First Name</label>
                        <input class="form-control" id="exampleFirst" type="text">
                    </div>
                    <div class="col-sm-6 pb-3">
                        <label for="exampleLast">Last Name</label>
                        <input class="form-control" id="exampleLast" type="text">
                    </div>
                    <div class="col-sm-6 pb-3">
                        <label for="exampleCity">City</label> <input class="form-control" id="exampleCity" type="text">
                    </div>
                    <div class="col-sm-3 pb-3">
                        <label for="exampleSt">State</label> <select class="form-control custom-select" id="exampleSt">
                            <option class="text-white bg-warning">
                                Pick a state
                            </option>

                        </select>
                    </div>
                    <div class="col-sm-3 pb-3">
                        <label for="exampleZip">Postal Code</label>
                        <input class="form-control" id="exampleZip" type="text">
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="exampleAccount">Preferred Color (radio buttons)</label>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input autocomplete="off" checked id="blue" name="options" type="radio">
                                Blue
                            </label>
                            <label class="btn btn-secondary">
                                <input autocomplete="off" id="red" name="options" type="radio">
                                Red
                            </label>
                            <label class="btn btn-secondary">
                                <input autocomplete="off" id="green" name="options" type="radio">
                                Green
                            </label>
                            <label class="btn btn-secondary">
                                <input autocomplete="off" id="yellow" name="options" type="radio">
                                Yellow
                            </label>
                            <label class="btn btn-secondary">
                                <input autocomplete="off" id="black" name="options" type="radio">
                                Black
                            </label>
                            <label class="btn btn-secondary active">
                                <input autocomplete="off" id="orange" name="options" type="radio">
                                Orange
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 pb-3">
                        <label for="exampleMessage">Message</label>
                        <textarea class="form-control" id="complexExampleMessage" rows="3"></textarea>
                        <small class="text-muted">Add any notes here.</small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <input class="btn btn-secondary" type="reset" value="Cancel">
                    <input class="btn btn-primary" type="button" value="Send">
                </div>
            </div>
        </div><!--/card-->
    </div>
</div><!--/row-->
