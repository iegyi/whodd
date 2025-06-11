(function(request, requestClass, $) {
    "use strict";

    window.bitflan = {
        components: {
            ports_component: function() {
                return {
                    domain: '',
                    domain_org: '',
                    port: 0,
                    errors: {},
                    error: false,
                    error_message: '',
                    sending: false,
                    status: 'blank',
                    ports_render1: null,
                    ports_render2: null,

                    init(errorMessages) {
                        this.errors = errorMessages;
                        this.$watch('domain', () => {
                            this.error = false;
                            this.error_message = '';
                        });
                    },

                    singleQuery(port) {
                        return new Promise((resolve, reject) => {
                            const req = new vjaxClass();

                            req.post({
                                url: window.bitflan_baseUrl + 'open_ports_lookup/single_query',
                                data: {
                                    port: port,
                                    domain: this.domain
                                },
                                onResponse: (response) => {
                                    resolve(JSON.parse(response.text));
                                },
                                onError: (err) => console.error(err)
                            })
                        });
                    },
                    submit() {
                        this.data = null;
                        this.domain = '';
                        this.port = 0;
                        this.errors = {};
                        this.error = false;
                        this.error_message = '';
                        this.sending = false;
                        this.status = 'blank';
                        this.ports_render1 = null;
                        this.ports_render2 = null;
                        if($('#resultcontent').hasClass('result-content')) {
                            $('#resultcontent').removeClass('result-content');
                        }
                        if (!this.sending) {
                            this.domain = document.getElementById("inputboxvalue").value;
                            this.domain_org = this.domain;
                            if (this.domain.trim().length) {
                                request.post({
                                    url: window.bitflan_baseUrl + 'open_ports_lookup/query',
                                    data: {
                                        url: this.domain,
                                    },
                                    onSend: () => {
                                        this.sending = true;
                                        this.ports_render1 = [];
                                        this.ports_render2 = [];
                                        this.status = 'blank';
                                    },
                                    onResponse: (response) => {
                                            const data = JSON.parse(response.text);
                                            this.sending = false;
                                            if (data.type == 'error') {
                                                this.error = true;
                                                this.error_message = data.message;
                                                this.ports_render1 = [];
                                                this.ports_render2 = [];
                                                this.status = 'blank';
                                            } else {
                                                if(!$('#resultcontent').hasClass('result-content')) {
                                                    $('#resultcontent').addClass('result-content');
                                                }
                                                this.domain = data.domain;
                                                const midIndex = Math.floor(data.ports.length / 2);
                                                this.ports_render1 = data.ports.slice(0, midIndex);
                                                this.ports_render2 = data.ports.slice(midIndex);
                                            }
                                    },
                                    onError: () => {
                                        if($('#resultcontent').hasClass('result-content')) {
                                            $('#resultcontent').removeClass('result-content');
                                        }
                                        this.sending = false;
                                        this.error = true;
                                        this.error_message = this.errors.invalid_url_unknown;
                                        this.ports_render1 = [];
                                        this.ports_render2 = [];
                                        this.status = 'blank';
                                    }
                                })
                            } else {
                                if($('#resultcontent').hasClass('result-content')){
                                    $('#resultcontent').removeClass('result-content');
                                }
                                this.sending = false;
                                this.ports_render1 = [];
                                this.ports_render2 = [];
                            }
                        }
                    }
                }
            }
        }
    };
})(vjax, vjaxClass, jQuery)