   <div class="modal fade py-0" id="sizemodal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal__card">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- #card -->
                                <div class="col-12 row">
                                    <div class="col-md-4 col-12">
                                        <img src="{{asset("website/assets/modal_img.svg")}}" alt="Run Tight Trouser"
                                            class="product-card__img ">
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <h6 class="mt-3 ">Run Tight Trouser</h6>
                                        <p class="text-muted mb-0">Men's Shoes <br> Size: M</p>
                                        <p class="product-card__price mt-4 mb-0">132.00 EGP</p>
                                        <p class="product-card__offer"><span>560</span> EGP</p>
                                    </div>
                                </div>
                                <hr class="mt-4">
                                <!-- #colors -->
                                <div class="col-12 ps-1 row">
                                    <h5>color</h5>
                                </div>
                                <div class="col-12 mb-3 row ">
                                    <div class="row row-cols-4 row-cols-md-6 ps-2 g-2  color-options">
                                        <!-- Example color swatch item -->
                                        <div class="col color-item">
                                            <input type="checkbox" id="color-yellow" name="color" value="Yellows" />
                                            <label for="color-yellow">
                                                <span class="color-circle" style="background-color: #F7DF1E;"></span>
                                                <span class="color-name">Yellows</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-purple" name="color" value="Purple" />
                                            <label for="color-purple">
                                                <span class="color-circle" style="background-color: #7B5BA5;"></span>
                                                <span class="color-name">Purple</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-gray" name="color" value="Gray" />
                                            <label for="color-gray">
                                                <span class="color-circle" style="background-color: #B8B8B8;"></span>
                                                <span class="color-name">Gray</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-white" name="color" value="White" />
                                            <label for="color-white">
                                                <span class="color-circle"
                                                    style="background-color: whitesmoke; border: 1px solid #ccc;"></span>
                                                <span class="color-name">White</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-kaki" name="color" value="Kaki" />
                                            <label for="color-kaki">
                                                <span class="color-circle" style="background-color: #C3B091;"></span>
                                                <span class="color-name">Kaki</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-browns" name="color" value="Browns" />
                                            <label for="color-browns">
                                                <span class="color-circle" style="background-color: #5A3E36;"></span>
                                                <span class="color-name">Browns</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-roses" name="color" value="Roses" />
                                            <label for="color-roses">
                                                <span class="color-circle" style="background-color: #F08FB7;"></span>
                                                <span class="color-name">Roses</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-blacks" name="color" value="Blacks" />
                                            <label for="color-blacks">
                                                <span class="color-circle" style="background-color: #000000;"></span>
                                                <span class="color-name">Blacks</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-green" name="color" value="Green" />
                                            <label for="color-green">
                                                <span class="color-circle" style="background-color: #6B8E23;"></span>
                                                <span class="color-name">Green</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-maroon" name="color" value="Maroon" />
                                            <label for="color-maroon">
                                                <span class="color-circle" style="background-color: #800000;"></span>
                                                <span class="color-name">Maroon</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-orange" name="color" value="Orange" />
                                            <label for="color-orange">
                                                <span class="color-circle" style="background-color: #FFA500;"></span>
                                                <span class="color-name">Orange</span>
                                            </label>
                                        </div>

                                        <div class="col color-item">
                                            <input type="checkbox" id="color-beiges" name="color" value="Beiges" />
                                            <label for="color-beiges">
                                                <span class="color-circle" style="background-color: #DCC7A1;"></span>
                                                <span class="color-name">Beiges</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-4">
                                <!-- #sizes -->
                                <div class="col-12 mb-3 ps-1 row">
                                    <h5>Sizes</h5>
                                </div>
                                <div class="col-12 row">
                                    <div class="size-group__options ps-3">
                                        <input type="radio" id="clothes-xs" name="clothes-size" value="XS">
                                        <label for="clothes-xs">XS</label>

                                        <input type="radio" id="clothes-s" name="clothes-size" value="S">
                                        <label for="clothes-s">S</label>

                                        <input type="radio" id="clothes-m" name="clothes-size" value="M" checked>
                                        <label for="clothes-m">M</label>

                                        <input type="radio" id="clothes-l" name="clothes-size" value="L">
                                        <label for="clothes-l">L</label>

                                        <input type="radio" id="clothes-xl" name="clothes-size" value="XL">
                                        <label for="clothes-xl">XL</label>

                                        <input type="radio" id="clothes-xxl" name="clothes-size" value="XXL">
                                        <label for="clothes-xxl">XXL</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="button__primary__large d-none d-md-block  m-auto">Add To
                                    Cart</button>
                                <button type="button" class="button__primary__medium d-block d-md-none m-auto">Add To
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>