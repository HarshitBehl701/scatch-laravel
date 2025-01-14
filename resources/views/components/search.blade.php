<button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="{{$mdScreen  ==  'block'  ?  'block md:hidden'   :   'hidden md:block'}} text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
    </svg>
    <span class="sr-only">Search</span>
</button>

<!-- Search Input -->
<div class="relative {{$mdScreen  ==  'block'  ?  'hidden md:block mr-2'   :   'block md:hidden'}}">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
        <span class="sr-only">Search icon</span>
    </div>
    <form action="/products" method="get">
        <input type="text" id="search-navbar{{$elemIndex}}" class="block w-full md:w-96 cursor-pointer p-2 ps-10 text-sm text-gray-900 border border-gray-300 {{$mdScreen  ==  'block'  ?  'rounded-full'   :   'rounded-lg'}} bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Products...">
    </form>
    
    <!-- Search Results -->
    <div id="search-results{{$elemIndex}}" class="absolute z-10 w-full bg-white dark:bg-gray-700 shadow-lg rounded-md mt-2 hidden">
        <ul class="search-list{{$elemIndex}} text-gray-700 dark:text-white max-h-40 overflow-y-auto"></ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search-navbar{{$elemIndex}}");
        const searchResults = document.getElementById("search-results{{$elemIndex}}");
        const searchList = document.querySelector(".search-list{{$elemIndex}}");

        searchInput.addEventListener("input",async function () {
            const query = this.value.trim();

            const response = await fetch('http://localhost:8000/api/v1/get_search_data')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            });
            
            const sampleData = await  response.data ?? [];
                
            searchList.innerHTML = "";
            searchResults.classList.add("hidden");

            if (query.length > 0) {
                const filteredResults = sampleData.filter(item =>
                    item.toLowerCase().includes(query.toLowerCase())
                );

                if (filteredResults.length > 0) {
                    filteredResults.forEach(item => {
                        const li = document.createElement("li");
                        li.classList.add("p-2", "hover:bg-gray-100", "dark:hover:bg-gray-600", "cursor-pointer");
                        const anchor = document.createElement("a");
                        anchor.classList.add("block", "w-full", "h-full");
                        anchor.textContent = item;
                        anchor.href = `/products/${encodeURIComponent(item)}`;
                        li.appendChild(anchor);
                        searchList.appendChild(li);
                    });

                    searchResults.classList.remove("hidden");
                }
            }
        });

        document.addEventListener("click", function (event) {
            if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                searchResults.classList.add("hidden");

            }
        });
    });
</script>