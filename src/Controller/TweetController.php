<?php

namespace Twitter\Controller;

use Twitter\Http\Request;
use Twitter\Http\Response;
use Twitter\Model\JsonTweetModel;
use Twitter\Model\TweetModel;
use Twitter\Model\TweetModelInterface;

class TweetController extends Controller
{
    protected TweetModelInterface $model;

    public function __construct(TweetModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @return Response
     */
    public function listTweets(): Response
    {
        return $this->render('tweet/list', [
            'tweets' => $this->model->findAll(),
            "name" => "Deborah"
        ]);
    }

    public function displayForm(): Response
    {
        return $this->render('tweet/form');
    }

    public function saveTweet(Request $request): Response
    {
        // 1. Fetch the content on request
        // $content = $request->getParam('content');

        // 2. Save the tweet
        $this->model->insert('Deborah', $request->getParam('content'));

        return $this->redirect('/');
    }

    public function delete(Request $request): Response
    {
        // 1. Fetch the ID that we have to delete ($request)
        // $id = $request->getParam('id');

        // 2. Delete the tweet (Model)
        $this->model->remove($request->getParam('id'));
        return $this->redirect('/');
    }
}
