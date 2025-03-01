<section class="hero-section">
    <div class="hero-holder">
        <h1>Ryan A. Smith</h1>
        <h2 style="margin-top:20px;">Fullstack Engineer, Musician, Guinea Pig Enthusiast</h2>
        <div class="cta-buttons">
            <a href="/blog" class="btn">View My Blog</a>
            <a href="/about" class="btn">About Me</a>
        </div>
    </div>
</section>

<section class="content-section">
    <h2>What I Do</h2>
    <p>I specialize in designing and developing enterprise software, cloud architectures, and microservices. With a focus on scalability and efficiency, I build high-performance systems that drive business success.</p>
    <h2>Get in Touch</h2>
    <p>Feel free to reach out via email or connect on social media.</p>
    <div class="socials-holder">
        <a href="#" id="email-link" target="_blank" rel="noopener noreferrer">
            Email
        </a>            
        <a href="https://www.linkedin.com/in/ryan-smith-188a14148/" target="_blank" rel="noopener noreferrer">
            LinkedIn
        </a>
        <a href="https://github.com/cloudsmithr/" target="_blank" rel="noopener noreferrer">
            GitHub
        </a>
    </div>
</section>

<script>
    const p1 = 'ryan';
    const p2 = 'rsmith';
    const p3 = 'cloud'
    const asd = p1 + '@' + p2 + '.' + p3;

    const link = document.getElementById('email-link');

    link.addEventListener('click', function(e) {
        e.preventDefault();
        this.href = 'mailto:' + asd;
        window.location.href = this.href;
    });

    link.addEventListener('contextmenu', function(e) {
        this.href = 'mailto:' + asd;
    });
</script>
