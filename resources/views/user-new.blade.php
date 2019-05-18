<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Book Society - Add new user</title>


        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,600"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="/css/all.min.css">
        <link href="/css/app.css" rel="stylesheet" />

        <!-- Styles -->
        <style></style>
    </head>
    <body>
        <nav
            id="book-society-navbar"
            class="navbar navbar-expand-lg navbar-light bg-light"
        >
            <a class="navbar-brand" href="/">BOOK SOCIETY</a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form
                    class="form-inline my-2 my-lg-0"
                    action="/search"
                    method="get"
                >
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend input-group-sm">
                            <select
                                class="search-scope custom-select"
                                name="search-scope"
                            >
                                <option value="book" selected>Book</option>
                                <option value="author">Author</option>
                            </select>
                        </div>
                        <input
                            type="text"
                            class="form-control"
                            name="q"
                            placeholder="Search"
                            aria-label="Search query"
                            aria-describedby="basic-addon2"
                        />
                        <div class="input-group-append">
                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                            >
                                <svg
                                    id="i-search"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 32 32"
                                    width="32"
                                    height="32"
                                    fill="none"
                                    stroke="currentcolor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                >
                                    <circle cx="14" cy="14" r="12" />
                                    <path d="M23 23 L30 30" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
                <a href="/books/new" class="add-book-action"><i class="fa fa-book"></i></a>
            </div>
        </nav>

        <div class="container">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row new-user-form">
                <form action="/users/new" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="userid">User ID</label>
                        <input type="text" name="userid" id="userid" class="form-control" maxlength="13">
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" maxlength="13">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input class="form-control" type="text" name="dob" id="dob">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input name="role" id="role" cols="30" rows="10" class="form-control"/>
                    </div>
                    <button class="btn btn-primary btn-block">Add</button>
                </form>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
