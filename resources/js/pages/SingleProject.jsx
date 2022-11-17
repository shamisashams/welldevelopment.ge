import React, { useState } from "react";
import { BsCheck } from "react-icons/bs";
import SingleSlider from "../components/SingleSlider";
import { IoLocationSharp } from "react-icons/io5";
import { CallButton, Pagination } from "../components/Shared";
import { activeProject, projects } from "../components/Data";
import { ActiveProject, ProjectBox } from "../components/ProjectBoxes";
//import ProjectImg1 from "../assets/images/projects/active/1.png";
//import ProjectImg2 from "../assets/images/projects/active/2.png";
//import ProjectImg3 from "../assets/images/projects/active/3.png";
//import ProjectImg4 from "../assets/images/projects/active/4.png";
import CallPopup from "../components/CallPopup";
import Layout from "../Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'

const SingleProject = ({seo}) => {
  const [showPopup, setShowPopup] = useState(false);

  const {project, related_projects, project_apartments} = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });



    //console.log(project_apartments)

  const checks = [
    "ღია და დახურული პარკინგი",
    "რეკრეაციული სივრცე",
    "ბავშვთა გასართობი მოედანი",
    "24/7 ტერიტორიის ვიდეო კონტროლი",
    "სატვირთო და სამგზავრო ლიფტი",
  ];
  const imgs = [
    "/client/assets/images/projects/active/1.png",
    "/client/assets/images/projects/active/2.png",
    "/client/assets/images/projects/active/3.png",
    "/client/assets/images/projects/active/4.png",
    "/client/assets/images/projects/active/2.png",
    "/client/assets/images/projects/active/3.png",
  ];

  return (
      <Layout seo={seo}>
          <div className="wrapper">
              <div className="max-w-7xl mx-auto py-20">
                  <section className="flex lg:flex-row flex-col items-start">
                      <div className="lg:w-1/2 lg:mr-16  mb-10 w-full">
                          <div className="bold">{project.title}</div>
                          <p className="opacity-50 mt-2">
                              {" "}
                              <IoLocationSharp className="inline-block" /> {project.city?project.city.title:null}, {project.district?project.district.title:null}, {project.address}
                          </p>
                          <SingleSlider data={project.slider} />
                          <div className="flex justify-start mt-10 lg:flex-nowrap flex-wrap">
                              <p className="flex mr-5 mb-5 text-sm">
                                  <div className="lg:text-right opacity-50 pr-3 border-r border-slate-500">
                                      სარეკრეაციო სივრცე
                                  </div>
                                  <span className="bold text-xl pl-3 align-middle">
                  {project.recreational_space} კვ.მ
                </span>
                              </p>
                              <p className="flex  mr-5 mb-5 text-sm">
                                  <div className="lg:text-right opacity-50 pr-3 border-r  border-slate-500">
                                      ღია და დახურული ავტოსადგომი
                                  </div>
                                  <span className="bold text-xl pl-3 align-middle">{project.parking}</span>
                              </p>
                              <p className="flex mr-5 mb-5 text-sm">
                                  <div className="lg:text-right opacity-50 pr-3 border-r  border-slate-500">
                                      ხელმისაწვდომი ბინები
                                  </div>
                                  <span className="bold text-xl pl-3 align-middle">{project_apartments.total}</span>
                              </p>
                          </div>
                      </div>
                      <div className="max-w-lg">
                          <div className="mb-5">პროექტის აღწერა</div>
                          <p className="opacity-50 mb-5 border-b pb-5">
                              {renderHTML(project.description)}
                          </p>
                          <div className="mb-5">დეტალები</div>
                          {project.details.map((item, index) => {
                              return (
                                  <p key={index} className="opacity-50 mb-5">
                                      <BsCheck className="inline-block text-custom-blue w-5 h-5 mr-2" />
                                      {item.title}
                                  </p>
                              );
                          })}
                          <CallButton onClick={() => setShowPopup(true)} />
                          <p className="mt-5">
                              ან დაგვიკავშირდი: <a href="tel:+995579904804">+995 579 904 804</a>
                          </p>
                      </div>
                  </section>
                  <section className="my-10">
                      <div className="bold text-lg mb-10">ბინები კომპლექსში</div>
                      <div className="grid lg:grid-cols-3 sm:grid-cols-2 gap-y-10 gap-x-5 pb-5">
                          {project_apartments.data.map((item, index) => {
                              return (
                                  <ProjectBox
                                      key={index}
                                      link={route('client.apartment.show',item.slug)}
                                      img={item.latest_image?item.latest_image.full_url:null}
                                      title={item.title}
                                      para={item.para}
                                      bedroom={item.bedroom}
                                      bathroom={item.bathroom}
                                      dimension={item.dimension}
                                      active={item.active}
                                  />
                              );
                          })}
                      </div>
                      <Pagination data={project_apartments.links} />
                  </section>
                  <section className="my-20 pt-10">
                      <div className="bold text-2xl text-center mb-16">
                          სხვა აქტიური პროექტები
                      </div>
                      <div className="grid lg:grid-cols-3 sm:grid-cols-2 gap-y-10 gap-x-5 pb-5">
                          {related_projects.map((item, index) => {
                              return (
                                  <ActiveProject
                                      key={index}
                                      img={item.latest_image?item.latest_image.full_url:null}
                                      name={item.title}
                                      link={route('client.project.show',item.slug)}
                                  />
                              );
                          })}
                      </div>
                  </section>
              </div>
              <CallPopup show={showPopup} hide={() => setShowPopup(false)} />
          </div>
      </Layout>

  );
};

export default SingleProject;
