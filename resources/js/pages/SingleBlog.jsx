import React from "react";
//import bg from "../assets/images/bg/6.png";
import { FaCalendarAlt } from "react-icons/fa";
//import img1 from "../assets/images/other/4.png";
//import img2 from "../assets/images/other/5.png";
//import Icon4 from "../assets/images/icons/12.png";
//import Icon5 from "../assets/images/icons/13.png";
//import Icon6 from "../assets/images/icons/14.png";
import { BlogSlider } from "../components/ProjectSlider";
import { IconDiv, MainButton } from "../components/Shared";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import Layout from "../Layouts/Layout";

const SingleBlog = ({seo}) => {

    const {blog,related_blogs,localizations} = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

  return (
      <Layout seo={seo}>
          <>
              <section className="relative w-full lg:h-96 sm:h-60 h-40 bg-cover bg-center bg-black/[0.4] flex items-end ">
                  <img
                      className="-z-10 absolute w-full h-full left-0 top-0 object-cover"
                      src={blog.latest_image?blog.latest_image.full_url:null}
                      alt=""
                  />
                  <div className="mx-auto bold max-w-lg text-white pb-5 px-3">
                      {blog.title}
                  </div>
              </section>
              <section className="max-w-lg mx-auto px-3 py-5 text-justify text-sm mb-20">
                  <div className="opacity-50 text-sm mt-1 mb-6">
                      <FaCalendarAlt className="inline-block mr-1 mb-1" /> {blog.formatted_date}
                  </div>

                      {renderHTML(blog.text_top)}


                  {/*<p className="opacity-50 mb-6">
                      გაზაფხულის დამდეგი ზამთრიდან გაზაფხულისკენ გარდამავალი პერიოდია. დღე
                      იმატებს, მზე უფრო და უფრო მეტად ანათებს და ათბობს, განსაკუთრებით –
                      შუადღისას. ხელოვნური განათება საჭირო აღარ არის. სითბოს მოყვარული,
                      მაგრამ ჩრდილგამძლე ყვავილები ინტენსიურად იწყებენ ზრდას, სინათლის
                      მოყვარულები კი არ ჩქარობენ, რადგან მზის შუქი ჯერ კიდევ არ ჰყოფნით.
                  </p>
                  <p className="opacity-50 mb-6">
                      სჯობს, ქოთანი ფანჯარასთან ახლოს იდგეს. ოთახის მცენარეთა უმრავლესობა
                      ადრე გაზაფხულზე ჯერ კიდევ ისვენებს, ამიტომ მორწყვა მხოლოდ მაშინ
                      სჭირდება, როცა მიწის ზედა შრე შეშრება. მოსარწყავად სჯობს გადადუღებული
                      წყალი, რომლის ტემპერატურაც ოთახისაზე ოდნავ (1-20ჩ-ით) მაღალი იქნება.
                  </p>
                  <p className="opacity-50 mb-6">
                      აზალიების, კამელიების, კაქტუსების ქოთნებში მიწის ზედაპირზე
                      დასატენიანებლად შეიძლება თოვლი დავდოთ. ფოთლები მტვრისგან სისტემატურად
                      უნდა გაიწმინდოს სველი, კარგად გაწურული ნაჭრით. თუ ამჩნევთ, რომ ფოთოლი
                      დაშვებულია, უმჯობესია, სული შეუბეროთ ან რბილი ფუნჯით გაწმინდოთ.
                  </p>
                  <p className="opacity-50 mb-6">
                      ქოთანში მიწაც უნდა გაფაშრდეს. მცენარეს ღეროები და ფოთლები პერიოდულად
                      უნდა დაბანოთ. სასურველია, წყალში ცოტაოდენი სარეცხის საპონი გახსნათ.
                      აუცილებელია ოთახის რეგულარული განიავება, განსაკუთრებით – მზიან
                      დღეებში, თუმცა უნდა ვერიდოთ ორპირ ქარს, რომელიც მცენარეთა
                      უმრავლესობისთვის ძალიან საშიშია.
                  </p>
                  <div className="w-full rounded-xl mb-6 h-fit overflow-hidden ">
                      <img src="/client/assets/images/other/4.png" alt="" />
                  </div>
                  <p className="opacity-50 mb-6">
                      გაზაფხულის დამდეგი ზამთრიდან გაზაფხულისკენ გარდამავალი პერიოდია. დღე
                      იმატებს, მზე უფრო და უფრო მეტად ანათებს და ათბობს, განსაკუთრებით –
                      შუადღისას. ხელოვნური განათება საჭირო აღარ არის. სითბოს მოყვარული,
                      მაგრამ ჩრდილგამძლე ყვავილები ინტენსიურად იწყებენ ზრდას, სინათლის
                      მოყვარულები კი არ ჩქარობენ, რადგან მზის შუქი ჯერ კიდევ არ ჰყოფნით.
                  </p>
                  <p className="opacity-50 mb-6">
                      სჯობს, ქოთანი ფანჯარასთან ახლოს იდგეს. ოთახის მცენარეთა უმრავლესობა
                      ადრე გაზაფხულზე ჯერ კიდევ ისვენებს, ამიტომ მორწყვა მხოლოდ მაშინ
                      სჭირდება, როცა მიწის ზედა შრე შეშრება. მოსარწყავად სჯობს გადადუღებული
                      წყალი, რომლის ტემპერატურაც ოთახისაზე ოდნავ (1-20ჩ-ით) მაღალი იქნება.
                  </p>
                  <p className="opacity-50 mb-6">
                      აზალიების, კამელიების, კაქტუსების ქოთნებში მიწის ზედაპირზე
                      დასატენიანებლად შეიძლება თოვლი დავდოთ. ფოთლები მტვრისგან სისტემატურად
                      უნდა გაიწმინდოს სველი, კარგად გაწურული ნაჭრით. თუ ამჩნევთ, რომ ფოთოლი
                      დაშვებულია, უმჯობესია, სული შეუბეროთ ან რბილი ფუნჯით გაწმინდოთ.
                  </p>
                  <p className="opacity-50 mb-6">
                      ქოთანში მიწაც უნდა გაფაშრდეს. მცენარეს ღეროები და ფოთლები პერიოდულად
                      უნდა დაბანოთ. სასურველია, წყალში ცოტაოდენი სარეცხის საპონი გახსნათ.
                      აუცილებელია ოთახის რეგულარული განიავება, განსაკუთრებით – მზიან
                      დღეებში, თუმცა უნდა ვერიდოთ ორპირ ქარს, რომელიც მცენარეთა
                      უმრავლესობისთვის ძალიან საშიშია.
                  </p>*/}
                  {/*<div className="w-full rounded-xl mb-6 h-fit overflow-hidden ">
                      <img src="/client/assets/images/other/5.png" alt="" />
                  </div>*/}
                  <div className="bold text-center text-base pt-5 mb-6">
                      {__('client.social_share',localizations)}
                  </div>{" "}
                  <div className="flex items-center  justify-center mt-5">
                      <a href="#">
                          <IconDiv img="/client/assets/images/icons/12.png" />
                      </a>
                      <a className="mx-5" href="#">
                          <IconDiv img="/client/assets/images/icons/13.png" />
                      </a>
                      <a href="#">
                          <IconDiv img="/client/assets/images/icons/14.png" />
                      </a>
                  </div>
              </section>{" "}
              <section className="pb-20 wrapper">
                  <div className="bold text-xl mb-10">{__('client.other_blogs',localizations)}</div>
                  <BlogSlider items={related_blogs} />
              </section>
          </>
      </Layout>

  );
};

export default SingleBlog;
