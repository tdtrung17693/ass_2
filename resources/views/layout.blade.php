<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Book Society @hasSection('title') - @yield('title') @endif</title>

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,600"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="/css/all.min.css">
        <link href="/css/app.css" rel="stylesheet" />

        <!-- Styles -->
        <style></style>
        <script>
            const token = "{{ csrf_token() }}";
        </script>
    </head>
    <body @hasSection('body-class') @yield('body-class') @endif>
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
                <a href="/books/new" class="navbar-action add-book-action" title="Add new book"><i class="fa fa-book"></i></a>
                <a href="/communities/" class="navbar-action communities" title="Community"><i class="fa fa-users"></i></a>
                <a href="/users/" class="navbar-action user-manager" title="User management"><i class="fa fa-address-book"></i></a>
                <a href="/messenger" class="navbar-action msg-box" title="Messenger"><i class="fas fa-comment-alt"></i></a>
            </div>
        </nav>

        @hasSection ('isFluid')
        <div class="container-fluid">
        @else
        <div class="container">
        @endif
            @yield('main')
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
