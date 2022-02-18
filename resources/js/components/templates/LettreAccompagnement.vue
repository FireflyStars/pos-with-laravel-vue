<template>
    <div class="template-email">
        <div class="contenu">
            <div class="row auth-logo">
                <div class="col-6 p-lg-0 d-flex align-items-center">
                    <img src="../../images/logolcdt.png" height="55" />
                </div>
            </div>
            <div class="row pt-5">
                <div class="column col-6">
                    <div>
                        <b>{{ expediteur }}</b>
                    </div>
                    <div>{{ expediteur2 }}</div>
                    <div>{{ adresse }}</div>
                    <div>{{ adresse2 }}</div>
                    <div v-if="coord">Tel. {{ coord }}</div>
                    <div>{{ email }}</div>
                </div>

                <div class="column col-6">
                    <div>SARL</div>
                    <div>Civilité Prénom Nomn</div>
                    <div>310 Route de l'Odyssée</div>
                    <div>45700 CONFLANS SUR LOING</div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="column col-6"></div>

                <div class="column col-6">
                    <div>Chilly Mazarin, le XX juin 2021</div>
                </div>
            </div>
            <div>Madame X, Monsieur Y, Madame, Monsieur,</div>

            <div class="pt-3" v-html="content"></div>

            <div class="row pt-5">
                <div class="column col-8"></div>
                <div class="column col-4">
                    <div><b> L’équipe commerciale</b></div>
                    <div>Agence X</div>
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
import html2pdf from "html2pdf.js";
export default {
    name: "LettreAccompagnement",
    props: [
        "expediteur",
        "adresse",
        "coord",
        "expediteur2",
        "adresse2",
        "email",
        "content",
        "getPdf",
    ],
    setup(props) {
        return {};
    },
};
</script>

<style scoped>
.template-email {
    border: black 2px solid;
    width: 100%;
}

.contenu {
    width: 100%;
    padding: 50px !important;
    font-size: small;
    color: black;
}

span {
    color: black;
    font-size: xx-small;
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
</style>
