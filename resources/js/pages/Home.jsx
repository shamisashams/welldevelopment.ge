import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import HeroSlider from "../components/HeroSlider";
import {
  BlogSlider,
  ProjectSlider1,
  ProjectSlider2,
} from "../components/ProjectSlider";
import { CallButton, IconDiv, MainButton } from "../components/Shared";
//import Img1 from "../assets/images/other/1.png";
//import Img3 from "../assets/images/other/2.png";
//import Img2 from "../assets/images/blog/1.png";
import { AiFillPlayCircle } from "react-icons/ai";
//import Icon1 from "../assets/images/icons/15.png";
import CallPopup from "../components/CallPopup";
import { useState } from "react";

import Layout from "../Layouts/Layout";

import { Inertia } from "@inertiajs/inertia";

const Home = ({seo, page}) => {
  const [showPopup, setShowPopup] = useState(false);

  const {projects, apartments, blogs, errors, localizations, images} = usePage().props;

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
          <>
              <section>
                  <HeroSlider />
              </section>
              <section className="py-10 bg-custom-slate-200 ">
                  <div className="wrapper">
                      <div className="bold text-center text-3xl mb-10">
                          {__('client.active_projects',localizations)}
                      </div>
                      <ProjectSlider1 items={projects} />
                  </div>
              </section>
              <section className="wrapper py-10">
                  <div className="bold  text-2xl mb-6">{__('client.current_offers',localizations)}</div>
                  <ProjectSlider2 items={apartments} />
                  <div className="text-right py-5">
                      <Link href="/">
                          <MainButton text={__('client.all_offers',localizations)} />
                      </Link>
                  </div>
              </section>
              <section className="bg-custom-slate-200 py-10 relative">
                  <img className="absolute right-0 bottom-0 w-1/3" src="/client/assets/images/other/2.png" alt="" />
                  <div className="wrapper flex items-start justify-start relative z-20 flex-col lg:flex-row">
                      <div className="max-w-xl xl:mr-20 lg:mr-10 -translate-y-20">
                          <div className="overflow-hidden w-full h-fit rounded-3xl mb-10">
                              <img className="w-full h-full object-cover" src={images[0]} alt="" />
                          </div>
                          <div className="flex">
                              <div className="relative w-24 h-24 rounded-xl overflow-hidden shrink-0 mr-3">
                                  <img className="w-full h-full object-cover" src="/client/assets/images/blog/1.png" alt="" />
                                  <AiFillPlayCircle className="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 group-hover:animate-pulse w-9 h-9 text-white" />
                              </div>
                              <div>
                                  <div className="bold">{__('client.home_about_h',localizations)}</div>
                                  <p className="opacity-70 my-1 text-sm">
                                      {__('client.home_about_t',localizations)}
                                  </p>
                                  <Link href="/" className="text-custom-blue underline">
                                      {__('client.home_about_video',localizations)}
                                  </Link>
                              </div>
                          </div>
                      </div>
                      <div className="max-w-xl">
                          <div className="xl:text-5xl sm:text-3xl text-xl bold xl:mb-8 mb-3">
                              {__('client.home_about_h1',localizations)}
                          </div>
                          <p className="opacity-70 mb-7">
                              {__('client.home_about_t1',localizations)}
                          </p>
                          <Link href="/">
                              <MainButton text={__('client.learn_more',localizations)} />
                          </Link>
                          <div className="flex mt-12 mb-8">
                              <div className="rounded-lg mr-5">
                                  <IconDiv img="/client/assets/images/icons/15.png" />
                              </div>
                              <div className="bold">
                                  {__('client.home_contact_text',localizations)}
                              </div>
                          </div>
                          <div className="max-w-md">
                              <input
                                  className="bg-white"
                                  type="text"
                                  placeholder={__('client.form_name',localizations)}
                                  name="name"
                                  onChange={handleChange}
                              />
                              {errors.name && <div>{errors.name}</div>}
                              <input
                                  className="bg-white"
                                  type="text"
                                  placeholder={__('client.form_surname',localizations)}
                                  name="surname"
                                  onChange={handleChange}
                              />
                              {errors.surname && <div>{errors.surname}</div>}
                              <input
                                  className="bg-white"
                                  type="text"
                                  placeholder={__('client.form_email',localizations)}
                                  name="email"
                                  onChange={handleChange}
                              />
                              {errors.email && <div>{errors.email}</div>}
                              <input
                                  className="bg-white"
                                  type="text"
                                  placeholder={__('client.form_phone',localizations)}
                                  name="phone"
                                  onChange={handleChange}
                              />
                              {errors.phone && <div>{errors.phone}</div>}
                              <textarea
                                  className="bg-white"
                                  placeholder={__('client.form_message',localizations)}
                                  name="message"
                                  onChange={handleChange}
                              ></textarea>
                              {errors.message && <div>{errors.message}</div>}
                              <MainButton onClick={handleSubmit} text={__('client.form_send_btn',localizations)} />
                          </div>
                      </div>
                  </div>
              </section>
              <section className="py-20 ">
                  <div className="wrapper">
                      <div className="bold text-center text-3xl mb-10">{__('client.home_blog',localizations)}</div>
                      <BlogSlider items={blogs} />
                      <div className="text-right">
                          <Link href={route('client.blog.index')}>
                              <MainButton text={__('client.home_all_blogs',localizations)} />
                          </Link>
                      </div>
                  </div>
              </section>
              <div className="fixed right-10 bottom-5 z-40">
                  <CallButton onClick={() => setShowPopup(true)} />
              </div>
              <CallPopup show={showPopup} hide={() => setShowPopup(false)} />
          </>
      </Layout>

  );
};

export default Home;
