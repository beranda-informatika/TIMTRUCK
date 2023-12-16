                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada kesalahan input data! <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Project Form</h4>
                            <p class="text-muted font-14">
                                Form Input Master Project
                            </p>

                            <form id="forminproject" role="form" class="parsley-examples"
                                method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Kode project<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="kdproject" name="kdproject" placeholder="Kode project" value=""/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Nama project<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="namaproject" name="namaproject" placeholder="Nama project" value=""/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8 offset-4">
                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-light">Save</button>
                                       
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end col -->
