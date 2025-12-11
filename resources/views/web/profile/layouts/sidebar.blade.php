                <div class="MyAcountList col-lg-3  col-12">
                    <ul class="m-0 p-0">
                        <li class="MyAcountList__item">
                            <a href="{{ route('profile.index') }}" class="active">Personal Information</a>
                        </li>
                        <li class="MyAcountList__item">
                            <a href="">My Orders</a>
                        </li>
                        <li class="MyAcountList__item">
                            <a href="">Addresses</a>
                        </li>
                        <li class="MyAcountList__item">
                            <a href="">Returns</a>
                        </li>
                        <li class="MyAcountList__item">
                            <a href="{{ route('profile.security') }}">Change Password</a>
                        </li>
                        <li class="MyAcountList__item">
                            <a href="{{ route('web.auth.logout') }}" class="logout-link">Log Out</a>
                        </li>

                    </ul>
                </div>
