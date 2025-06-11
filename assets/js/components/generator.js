(function(request, requestClass, $) {
    "use strict";

    window.bitflan = {
        components: {
            generator_component: function() {
                return {
                    domain: '',
                    errors: {},
                    error: false,
                    error_message: '',
                    sending: false,
                    available: false,
                    data: null,
                    prevDomain: null,
                    selections: [],

                    init(errorMessages) {
                        this.errors = errorMessages;

                        this.$watch('domain', () => {
                            this.error = false;
                            this.error_message = '';
                        });
                    },

                    submit() {
                        this.data = null;
                        if (!this.sending) {
                            if (this.domain.length) {
                                request.post({
                                    url: window.bitflan_baseUrl + 'domain-generator/query',
                                    data: {
                                        keyword: this.domain,
                                        selections: this.selections
                                    },

                                    onSend: () => {
                                        this.sending = true;
                                        this.prevDomain = this.domain;

                                        this.data = null;
                                        this.available = null;
                                    },

                                    onResponse: (response) => {
                                        const data = JSON.parse(response.text);

                                        this.sending = false;
                                        if (data.type == 'error') {
                                            this.error = true;
                                            this.error_message = data.message;
                                            this.data = null;
                                            this.available = false;
                                        } else {
                                            const columns = [
                                                [],
                                                []
                                            ];
                                            data.message.forEach((el, i) => i % 2 == 0 ? columns[0].push(el) : columns[1].push(el));
                                            this.data = columns;
                                            this.$nextTick(() => {
                                                let element;
                                                if(element = document.querySelector(".scrollIntoView")) {
                                                    element.scrollIntoView();
                                                }
                                            });
                                        }
                                    },
                                    onError: () => {
                                        this.sending = false;
                                        this.error = true;
                                        this.error_message = this.errors.invalid_url_unknown;
                                        this.data = null;
                                        this.available = false;
                                    }
                                })
                            } else {
                                this.error = true;
                                this.error_message = this.errors.invalid_domain;
                                this.data = null;
                                this.available = false;
                            }
                        }
                    }
                }
            }
        }
    };

    var tele = document.getElementById('teleporter'),
    rec = document.getElementById('receiver');

    window.onresize = resize;
    resize();

    function resize() {
        const rChildren = rec.children;
        let numW = 0;
        
        [...rChildren].forEach(item => {
          item.outHTML = '';
          tele.appendChild(item);
        })  

        const teleW = tele.offsetWidth,
          tChildren = tele.children;

        [...tChildren].forEach(item => {
          numW += item.offsetWidth;

            if (numW > teleW) {
                item.outHTML = '';
                rec.appendChild(item);
            }
            if(rec.children.length==0){
                $(".receiver-more-btn").css({"display": "none"});
            }else
            {
                $(".receiver-more-btn").css({"display": "block"});
            }
        });
    }
    $('.nav-show-more-btn').on('click', function() {
    if($('.receiver-domains').hasClass('show')){
        $('.receiver-domains').removeClass('show');
    }
    else {
        $('.receiver-domains').addClass('show');
    }
    });
})(vjax, vjaxClass, jQuery)