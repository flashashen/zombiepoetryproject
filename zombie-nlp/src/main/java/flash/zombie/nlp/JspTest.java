package flash.zombie.nlp;


import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

@Controller
public class JspTest {

    @RequestMapping("/jsptest")
    public String test(ModelAndView modelAndView) {

        return "react";
    }

}


