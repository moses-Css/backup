<section class="bg-secondary">
    <!-- Hero Section -->
    <livewire:hero-section/>
    <section class=" text-neutralGray px-5">
    @livewire('kategori-tab')
    @livewire('galeri-grid')
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-secondary text-center">
        <h2 class="text-3xl font-semibold text-gray-800">Key Features</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mt-12">
            <div class="p-6 border rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Easy to Use</h3>
                <p class="mt-4 text-gray-600">Our platform is designed with a user-friendly interface that makes
                    managing your projects a breeze.</p>
            </div>
            <div class="p-6 border rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Cloud-Based</h3>
                <p class="mt-4 text-gray-600">Access your tasks from anywhere with our cloud-based system, fully secure
                    and reliable.</p>
            </div>
            <div class="p-6 border rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold">Real-Time Collaboration</h3>
                <p class="mt-4 text-gray-600">Collaborate with your team in real-time, ensuring fast communication and
                    task completion.</p>
            </div>
        </div>
    </section>


</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const buttons = document.querySelectorAll(".tab-btn");
        const items = document.querySelectorAll(".category-item");

        buttons.forEach(button => {
            button.addEventListener("click", function() {
                // Remove active styles from all buttons
                buttons.forEach(btn => {
                    btn.classList.remove("bg-blue-100", "text-blue-600");
                    btn.classList.add("text-gray-600");
                });

                // Add active style to clicked button
                this.classList.add("bg-blue-100", "text-blue-600");
                this.classList.remove("text-gray-600");

                const category = this.getAttribute("data-category");

                items.forEach(item => {
                    if (category === "all" || item.getAttribute("data-category") === category) {
                        item.classList.remove("hidden");
                    } else {
                        item.classList.add("hidden");
                    }
                });
            });
        });
    });
</script>