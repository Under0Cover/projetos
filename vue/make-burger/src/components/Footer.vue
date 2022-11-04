<template>
    <footer id="footer">
        <div>
            <p>Make Your Burguer &copy; 2022</p>
            <p class="autor">Tales Oliver</p>
        </div>
    </footer>
</template>

<script>
export default{
    name: "Footer"
}
</script>

<style scoped>
    #footer {
        height: 200px;
        background-color: #222;
        border-top: 4px solid #111;
        color: #FCBA03;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .autor {
        text-align: center;
        padding-top: 5px;
    }
</style>