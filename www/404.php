<style>
    .page-404 {
        display: flex;
        flex-direction: column;
        font-size: 1.5vw;
        justify-content: center;
        min-height: 85vh;
    }

    .page-404 img {
        mix-blend-mode: multiply;
        position: absolute;
        transform: translateX(-12%) translateY(-2%);
        width: 30%;
    }

    .page-404__title {
        display: flex;
        font-weight: 700;
        font-size: 15em;
        justify-content: center;
        line-height: .7;
        margin-bottom: 1rem;
    }

    .page-404__title__letter {
        align-items: center;
        display: flex;
        padding: .5rem;
        margin: 10px;
    }

    .page-404__title__circle {
        background-color: #4169E1;
        border-radius: 1em;
        height: 1em;
        width: 1em;
    }

    .page-404__subtitle {
        font-weight: bold;
        font-size: 3em;
        text-align: center;
    }
</style>
<div class="wrapper">
    <main>
        <div class="page-404">
            <div class="page-404__title">
                <div class="page-404__title__letter">4</div>
                <div class="page-404__title__letter">
                    <div class="page-404__title__circle"></div>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbSLnZ0KB4cbmz8cn54KZZxns1KpS94vVcHA&usqp=CAU" />
                </div>
                <div class="page-404__title__letter">4</div>
            </div>
            <div class="page-404__subtitle">Page not found...</div>
        </div>
    </main>
</div>