//import bg from "../assets/images/bg/5.png";
import { BsCheck } from "react-icons/bs";
import SingleSlider from "../components/SingleSlider";
import { IoLocationSharp } from "react-icons/io5";
import { CallButton, IconDiv } from "../components/Shared";
import { CiSearch } from "react-icons/ci";
import { TiHeartFullOutline } from "react-icons/ti";
import React, { useState } from "react";
//import Img1 from "../assets/images/projects/4.png";
import { ProjectSlider2 } from "../components/ProjectSlider";
//import Icon1 from "../assets/images/icons/7.png";
//import Icon2 from "../assets/images/icons/8.png";
//import Icon3 from "../assets/images/icons/9.png";
//import Icon4 from "../assets/images/icons/11.png";
import CallPopup from "../components/CallPopup";
import Layout from "../Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'
import { Inertia } from "@inertiajs/inertia";

const SingleApartment = ({seo}) => {
  const [favorite, setFavorite] = useState(false);
  const imgs = ["/client/assets/images/projects/4.png", "/client/assets/images/projects/4.png", "/client/assets/images/projects/4.png", "/client/assets/images/projects/4.png", "/client/assets/images/projects/4.png"];
  const [showPopup, setShowPopup] = useState(false);

  const {project_apartments,similar_apartments, apartment} = usePage().props;

  console.log(project_apartments,similar_apartments,apartment)

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    const addToFavorite = function (product) {
        //localStorage.removeItem('cart')
        let _cart = localStorage.getItem("welldevelopment_favorite");
        let cart;
        if (_cart !== null) {
            cart = JSON.parse(_cart);
        } else cart = [];

        // let qty = parseInt(document.getElementById("qty_add").value);

        if (cart.length > 0) {
            let exists = false;
            let index = 0;
            cart.forEach(function (el, i) {
                if (el.product.id === product.id) {
                    //el.qty += qty;
                    exists = true;
                    index = i;
                }
            });
            if (!exists) {
                let obj = {
                    product: product,
                    //qty: qty,
                };
                cart.push(obj);
            } else {
                cart.splice(index, 1);
            }
        } else {
            let obj = {
                product: product,
                //qty: qty,
            };
            cart.push(obj);
        }

        localStorage.setItem("welldevelopment_favorite", JSON.stringify(cart));
        console.log(JSON.parse(localStorage.getItem("welldevelopment_favorite")));
        //localStorage.removeItem('cart')
        Inertia.visit(window.location.href);
    };

  const checks = [
    "ღია და დახურული პარკინგი",
    "რეკრეაციული სივრცე",
    "ბავშვთა გასართობი მოედანი",
    "24/7 ტერიტორიის ვიდეო კონტროლი",
    "სატვირთო და სამგზავრო ლიფტი",
  ];
  return (
      <Layout seo={seo}>
          <div className="wrapper py-5">
              <div className="md:h-60 h-40 w-full relative p-4">
                  <img
                      className="w-full h-full object-cover absolute left-0 top-0 -z-10"
                      src={apartment.project.cover_slider.length > 0 ? apartment.project.cover_slider[0].full_url:null}
                      alt=""
                  />
                  <div
                      className="absolute left-0 top-0 w-full h-full"
                      style={{
                          background: "linear-gradient(to top ,#0036567c, transparent )",
                      }}
                  ></div>
                  <div className="max-w-7xl mx-auto bold sm:text-lg text-white h-full flex items-end z-20 relative pb-6">
                      <span> {apartment.project.title}</span>
                      <div className="flex justify-center items-center bg-white rounded-xl w-10 h-10 shrink-0 text-black -mb-2 ml-4 text-2xl">
                          <CiSearch />
                      </div>
                  </div>
              </div>
              <div className="max-w-7xl mx-auto py-10">
                  <div className="flex mb-10 justify-start">
                      <div>
                          <div className="bold">{apartment.title}</div>
                          <p className="opacity-50 text-sm">{apartment.project.title}</p>
                      </div>
                      <button
                          onClick={() => {
                              setFavorite(!favorite);
                              addToFavorite(apartment)
                          }}
                          className={`rounded-xl  shadow-md flex items-center justify-center w-10 h-10 bg-white shadow-lg ml-5  ${
                              favorite ? "text-red-500" : "text-gray-400"
                          } `}
                      >
                          <TiHeartFullOutline className="w-5 h-5" />
                      </button>
                  </div>
                  <section className="flex lg:flex-row flex-col items-start">
                      <div className="lg:w-1/2 lg:mr-16 mb-10 w-full">
                          <SingleSlider data={apartment.files} />
                          <div className="bold">{apartment.project.title}</div>
                          <p className="opacity-50 mt-2">
                              {" "}
                              <IoLocationSharp className="inline-block" /> {apartment.project.city?apartment.project.city.title:null}, {apartment.project.district?apartment.project.district.title:null}, {apartment.project.address}
                          </p>
                          <div className="flex text-center mt-10 text-sm flex-wrap">
                              <div className="mr-4 pr-4 mb-5 border-r">
                                  <p className="opacity-50 mb-2">საძინებელი</p>
                                  <p>
                                      <img className="inline-block mr-2" src="/client/assets/images/icons/7.png" alt="" />
                                      <span>3</span>
                                  </p>{" "}
                              </div>
                              <div className="mr-4 pr-4 mb-5 border-r">
                                  <p className="opacity-50 mb-2">საძინებელი</p>
                                  <p>
                                      <img className="inline-block mr-2" src="/client/assets/images/icons/8.png" alt="" />
                                      <span>2</span>
                                  </p>{" "}
                              </div>
                              <div className="mr-4 pr-4 mb-5 border-r">
                                  <p className="opacity-50 mb-2">მთლიანი ფართი</p>
                                  <p>
                                      <img className="inline-block mr-2" src="/client/assets/images/icons/9.png" alt="" />
                                      <span>124 M</span>
                                  </p>
                              </div>
                              <div className="mb-5">
                                  <p className="opacity-50 mb-2">სართული</p>
                                  <p>
                                      <img className="inline-block mr-2" src="/client/assets/images/icons/11.png" alt="" />
                                      <select className="border px-2 rounded" name="" id="">
                                          {apartment.floors.map((item, index) => {
                                              return <option value={item}>{item}</option>
                                          })}
                                          {/*<option value="">5</option>
                                          <option value="">4</option>
                                          <option value="">3</option>*/}
                                      </select>
                                  </p>
                              </div>
                          </div>
                      </div>
                      <div className="max-w-lg">
                          <div className="mb-5">პროექტის აღწერა</div>
                          <p className="opacity-50 mb-5 border-b pb-5">
                              {renderHTML(apartment.description)}
                          </p>
                          <div className="mb-5">დეტალები</div>
                          {apartment.details.map((item, index) => {
                              return (
                                  <p key={index} className="opacity-50 mb-5">
                                      <BsCheck className="inline-block text-custom-blue w-5 h-5 mr-2" />
                                      {item.title}
                                  </p>
                              );
                          })}
                          <button
                              onClick={() => {
                                  "";
                              }}
                          >
                              <CallButton onClick={() => setShowPopup(true)} />
                          </button>
                          <p className="mt-5">
                              ან დაგვიკავშირდი: <a href="tel:+995579904804">+995 579 904 804</a>
                          </p>
                      </div>
                  </section>
              </div>
              <section className="py-20">
                  <div className="bold text-lg mb-10">სხვა ბინები იგივე კომპლექსში</div>
                  <ProjectSlider2 items={project_apartments} />
              </section>
              <section className="pb-20">
                  <div className="bold text-lg mb-10">მსგავსი ბინები</div>
                  <ProjectSlider2 items={similar_apartments} />
              </section>
              <CallPopup show={showPopup} hide={() => setShowPopup(false)} />
          </div>
      </Layout>

  );
};

export default SingleApartment;
