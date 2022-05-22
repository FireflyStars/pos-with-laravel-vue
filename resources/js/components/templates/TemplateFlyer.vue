<template>
    <div class="email-template">
        <div class="contenu">
            <div>
                <img src="../../images/Flyer.png" style="width: 100%; height: 100%" />
            </div>
            <div>
                <div>
                    <span>Contact</span>
                </div>

                <div class="row pt-3">
                    <div class="column col-3"></div>

                    <div class="column col-6">
                        <div>
                            <span style="color: orangered">Contact</span>
                        </div>
                        <div class="text-flyer">
                            <div>
                                <span>{{ contact }}</span> -
                                <span> {{ contact2 }}</span>
                            </div>
                            <div>Agence {{ agence }}</div>
                            <div>{{ coord }}</div>
                            <div>{{ email }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row auth-logo pt-3">
                <div class="col-6" style="padding: 0 20%">
                    <img src="../../images/logolcdt.png" height="55" />
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="text_footer">
                <span>LE RESEAU EXPERT </span>
                <span style="color: orangered">DES TOITS PROFESSIONNELS</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TemplateFlyer",
    props: ["contact", "contact2", "agence", "coord", "email"],
    setup(props) {
        return {};
    },
};
</script>

<style>
.email-template {
    border: 2px solid black;
}
.contenu {
    width: 100%;
    font-size: small;
    color: black;
}

.text_footer {
    background: white;
    padding: 0 3px;
    font-size: xx-small;
    font-weight: bold;
    margin-top: -1px;
}

#footer {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    background-color: orangered;
    margin-top: auto;
    height: 10px;
    padding: 0 40px 0 0;
    margin-bottom: 20px;
}
.text-flyer {
    border: 2px solid orangered;
    text-align: center;
    padding: 20px;
}
</style>
