import React, {useState} from "react";
import { IconDiv, MainButton } from "../components/Shared";
//import Icon1 from "../assets/images/icons/1.png";
//import Icon2 from "../assets/images/icons/2.png";
//import Icon3 from "../assets/images/icons/3.png";
//import Icon7 from "../assets/images/icons/16.png";
//import Icon8 from "../assets/images/icons/15.png";
//import AbsImg1 from "../assets/images/other/6.png";
//import AbsImg2 from "../assets/images/other/7.png";
import Layout from "../Layouts/Layout";
import { Inertia } from "@inertiajs/inertia";
import { Link, usePage } from '@inertiajs/inertia-react'

const Contact = ({seo,info}) => {

    const {errors, localizations} = usePage().props;

    const [values, setValues] = useState({
        name: "",
        surname: "",
        email: "",
        phone: "",
        message: "",
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setValues((values) => ({
            ...values,
            [key]: value,
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        Inertia.post(route("client.contact.mail"), values);
    }

  return (
      <Layout seo={seo}>
          <div>
              <img className="absolute left-0 top-0 -z-10" src="/client/assets/images/other/6.png" alt="" />

              <section className="wrapper">
                  <div className="max-w-4xl mx-auto mt-10">
                      <div className="flex items-center justify-center mb-5">
                          <IconDiv img="/client/assets/images/icons/16.png" />

                          <span className="pl-4 bold">{__('client.contact_t1',localizations)}</span>
                      </div>
                      <div className="rounded-2xl overflow-hidden shadow-lg mb-16">
                          <iframe
                              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8424.22872189371!2d44.735434467736575!3d41.71157098212468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x404473687fe0f66d%3A0x7fb7037984df0a44!2zNDHCsDQyJzM5LjIiTiA0NMKwNDMnMzguMSJF!5e0!3m2!1sen!2sge!4v1667544902356!5m2!1sen!2sge"
                              width="100%"
                              height="100%"
                              allowFullScreen=""
                              loading="lazy"
                              referrerPolicy="no-referrer-when-downgrade"
                          ></iframe>
                      </div>
                      <div className="relative flex justify-between items-start pb-20 flex-col md:flex-row">
                          <img
                              className="md:block hidden absolute left-28 bottom-0 -z-10"
                              src="/client/assets/images/other/7.png"
                              alt=""
                          />
                          <div className="item-1 mb-12">
                              <div className="flex items-center justify-start mb-5">
                                  <IconDiv img="/client/assets/images/icons/1.png" />

                                  <span className="pl-4">{info.email}</span>
                              </div>
                              <div className="flex items-center justify-start mb-5">
                                  <IconDiv img="/client/assets/images/icons/2.png" />

                                  <span className="pl-4">{info.phone}</span>
                              </div>
                              <div className="flex items-center justify-start mb-5">
                                  <IconDiv img="/client/assets/images/icons/3.png" />

                                  <span className="pl-4">
                  {info.address}
                </span>
                              </div>
                          </div>
                          <div className="item-2">
                              <div className="flex items-center justify-center mb-5">
                                  <IconDiv img="/client/assets/images/icons/15.png" />

                                  <span className="pl-4 bold">
                  {__('client.contact_t2',localizations)}
                </span>
                              </div>
                              <form onSubmit={handleSubmit} className=" max-w-sm mx-auto text-center">
                                  <input
                                      className="bg-gray-100 text-sm rounded-2xl"
                                      type="text"
                                      name="name"
                                      placeholder={__('client.form_name',localizations)}
                                      onChange={handleChange}
                                  />
                                  {errors.name && <div>{errors.name}</div>}
                                  <input
                                      className="bg-gray-100 text-sm rounded-2xl"
                                      type="text"
                                      name="surname"
                                      placeholder={__('client.form_surname',localizations)}
                                      onChange={handleChange}
                                  />
                                  {errors.surname && <div>{errors.surname}</div>}
                                  <input
                                      className="bg-gray-100 text-sm rounded-2xl"
                                      type="email"
                                      name="email"
                                      placeholder={__('client.form_email',localizations)}
                                      onChange={handleChange}
                                  />
                                  {errors.email && <div>{errors.email}</div>}
                                  <input
                                      className="bg-gray-100 text-sm rounded-2xl"
                                      type="number"
                                      name="phone"
                                      placeholder={__('client.form_phone',localizations)}
                                      onChange={handleChange}
                                  />
                                  {errors.phone && <div>{errors.phone}</div>}
                                  <div className="">
                  <textarea
                      className="h-32 bg-gray-100 text-sm rounded-2xl"
                      placeholder={__('client.form_message',localizations)}
                      name="message"
                      onChange={handleChange}
                  />
                                      {errors.message && <div>{errors.message}</div>}
                                  </div>
                                  <MainButton text={__('client.form_send_btn',localizations)} />
                              </form>
                          </div>
                      </div>
                  </div>
              </section>
          </div>
      </Layout>

  );
};

export default Contact;
